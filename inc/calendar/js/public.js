jQuery(document).ready(function($) {
	var targetMargin,
		scriptFullCalendar,
		scriptLocalCalendar,
		month,
		$activeButton,
		year = new Date().getFullYear(),
		_startDate = "",
		_endDate = "",
		_title = "Терем",
		jsFromDate,
		jsToDate,
		currentCalendarId;

	$(".booking-houses__calendars-all-button").on("click", function(event) {
		event.preventDefault();
		$(".booking-houses__calendars-button").trigger("click");
		$(this).remove();
		month = $("#admin-month option:selected").val();
		$("#admin-month").remove();
		year = $("#admin-years option:selected").val();
		$("#admin-years").remove();
	});

	$(".booking-houses__calendars-button, .our-house__button-booking").on(
		"click",
		function(event) {
			event.preventDefault();

			var func = loadCalendar.bind(this);
			if (!scriptFullCalendar) {
				scriptFullCalendar = document.createElement("script");
				scriptLocalCalendar = document.createElement("script");

				scriptFullCalendar.onload = function() {
					scriptLocalCalendar.src =
						"https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js";
					document
						.getElementsByTagName("body")[0]
						.appendChild(scriptLocalCalendar);
				};

				scriptLocalCalendar.onload = function() {
					func();
				};

				scriptFullCalendar.src =
					"https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js";
				document
					.getElementsByTagName("body")[0]
					.appendChild(scriptFullCalendar);
			} else {
				func();
			}
		}
	);

	function loadCalendar() {
		var calendarShortcod = $(this).data("calendar");
		var attArray = calendarShortcod.split('"');
		var data = {
			action: "calendar_action",
			id: attArray[1],
			slug: attArray[3]
		};
		var $parent = $(this)
			.parent()
			.parent()
			.parent()
			.find(".booking-houses__calendars-inner");
		var $title = $(this)
			.parent()
			.parent()
			.parent()
			.find(".booking-houses__title");
		var $parentDate = $(this)
			.parent()
			.parent()
			.parent()
			.find(".our-house__date");
		var $orderButton = $(this)
			.parent()
			.parent()
			.parent()
			.find(
				".our-house__button[data-name], .house-booking__button[data-name]"
			);
		if (!$orderButton.length) {
			$orderButton = $("[data-name]");
		}
		var $teremButton = $(".terem-button");
		var $orderBookingButton = $(this)
			.parent()
			.parent()
			.find(".our-house__button-hidden");
		var $textHelper;
		var events;

		function setDate() {
			const msg = $textHelper.data("helper-start");
			$(".select-helper__text")
				.removeClass("select-helper__text_success")
				.html(msg);

			$("[data-name]").each(function(index) {
				const item = $(this);
				const bookingId = $(item).data("id");
				const calendarId = $(item).data("cd");
				const title = $(item).data("name");
				let baseHref = `/booking-form/?booking=${bookingId}&calendarId=${calendarId}`;
				if ($(item).hasClass("is-terem-js")) {
					baseHref += `&terem=${title}`;
				}
				$(item).attr("href", baseHref);
			});

			if ($teremButton.length) {
				const bookingId = $($teremButton[0]).data("id");
				const baseHref = `/booking-form/?booking=${bookingId}`;
				$($teremButton[0]).attr("href", baseHref);
			}
		}
		$(this).remove();

		$.ajax(kg_ajax.url, {
			data: data,
			method: "post",
			success: function(response) {
				if (response) {
					$parent.empty().html(response);
					$textHelper = $parent.parent().find(".select-helper__text");
					$orderBookingButton.removeClass("our-house__button-hidden");
					var $calendar = $parent.find("[data-url]");
					var cUrl = $calendar.data("url");
					$calendar.fullCalendar({
						height: 300,
						loading: function(r) {
							$parentDate.css({ "max-width": 292 });
							if (!targetMargin) {
								var cielWidth = $($(".fc-day-top")[0]).width();
								if (cielWidth) {
									targetMargin = cielWidth / 2;
								}

								if (targetMargin) {
									var css =
											".fc-view .fc-body .fc-start { margin-left: " +
											targetMargin +
											"px; border-top-left-radius: 5px;border-bottom-left-radius: 5px;}.fc-view .fc-body .fc-end { margin-right: " +
											targetMargin +
											"px; border-top-right-radius: 5px;border-bottom-right-radius: 5px;}",
										head =
											document.head ||
											document.getElementsByTagName(
												"head"
											)[0],
										style = document.createElement("style");

									head.appendChild(style);

									style.type = "text/css";
									style.appendChild(
										document.createTextNode(css)
									);
								}
							}
							1 == r
								? $calendar.children("#cloader").show()
								: $calendar.children("#cloader").hide();
						},
						locale: "ru",
						header: {
							left: "prev",
							center: "title",
							right: "next"
						},
						events: {
							url: cUrl,
							success: function(doc) {
								events = doc;
							},
							error: function() {
								console.log("Ошибка загрузки данных");
							}
						},
						eventAfterAllRender: function() {
							if (jsFromDate) {
								var element = document.querySelector(
									`#calendar_${currentCalendarId} .fc-widget-content[data-date="${jsFromDate.d}"]`
								);
								if (element) {
									jsFromDate = {
										d: jsFromDate.d,
										el: element
									};
									$(jsFromDate.el).addClass("cell-range");
								}
							}

							if (jsToDate) {
								var element = document.querySelector(
									`#calendar_${currentCalendarId}  .fc-widget-content[data-date="${jsToDate.d}"]`
								);
								if (element) {
									jsToDate = { d: jsToDate.d, el: element };
									$(jsToDate.el).addClass("cell-range");
								}
							}

							fillCells();
						},
						dayClick: function(date, jsEvent, view) {
							setDate();
							var d = date.format("YYYY-MM-DD");
							if (!currentCalendarId) {
								currentCalendarId = data.id;
								initFrom(d, this);
							} else if (currentCalendarId != data.id) {
								clearAll();
								fillCells();
								currentCalendarId = data.id;
								initFrom(d, this);
							} else {
								if (!jsFromDate) {
									initFrom(d, this);
								} else if (jsFromDate && jsFromDate.d === d) {
									clearAll();
									fillCells();
								} else if (
									jsFromDate &&
									!jsToDate &&
									jsFromDate.d < d &&
									checkDateRange2(events, jsFromDate.d, d)
								) {
									jsToDate = { d: d, el: this };
									$(jsToDate.el).addClass("cell-range");
									fillCells();
								} else if (
									jsFromDate &&
									jsToDate &&
									jsToDate.d !== d &&
									jsFromDate.d < d &&
									checkDateRange2(events, jsFromDate.d, d)
								) {
									$(jsToDate.el)
										.removeClass("cell-range")
										.empty();
									jsToDate = { d: d, el: this };
									$(jsToDate.el).addClass("cell-range");

									fillCells();
								} else if (jsToDate && jsToDate.d === d) {
									$(jsToDate.el)
										.removeClass("cell-range")
										.empty();
									jsToDate = null;
									fillCells();
								}
							}

							if (jsFromDate && jsToDate) {
								const fromDateClearFormat = new moment(
									jsFromDate.d,
									"YYYY-MM-DD"
								);

								const toDateClearFormat = new moment(
									jsToDate.d,
									"YYYY-MM-DD"
								);
								$textHelper
									.addClass("select-helper__text_success")
									.html(
										`Дата бронирования:<br>${fromDateClearFormat.format(
											"DD-MM-YYYY"
										)} &mdash; ${toDateClearFormat.format(
											"DD-MM-YYYY"
										)}`
									);
								buttonAnimate($orderButton);

								const bookingId = $($orderButton[0]).data("id");
								const calendarId = $($orderButton[0]).data(
									"cd"
								);

								let baseHref = `/booking-form/?booking=${bookingId}&calendarId=${calendarId}&from=${jsFromDate.d}&to=${jsToDate.d}`;
								if (
									$($orderButton[0]).hasClass("is-terem-js")
								) {
									const titleTerem = jQuery(
										$orderButton[0]
									).data("name");
									baseHref += `&terem=${titleTerem}`;
								}
								$($orderButton[0]).attr("href", baseHref);
								if ($orderButton[1]) {
									$($orderButton[1]).attr("href", baseHref);
								}
							} else if (jsFromDate) {
								const fromDateClearFormat = new moment(
									jsFromDate.d,
									"YYYY-MM-DD"
								);

								$textHelper
									.removeClass("select-helper__text_success")
									.html(
										`Заезд: ${fromDateClearFormat.format(
											"DD-MM-YYYY"
										)}`
									);
							} else {
								$textHelper
									.removeClass("select-helper__text_success")
									.html($textHelper.data("helper-start"));
							}
						}
					});

					function initFrom(d, el) {
						var a = new moment(Date.now());
						if (
							d >= a.format("YYYY-MM-DD") &&
							checkStartDate(events, d)
						) {
							jsFromDate = { d: d, el: el };
							$(jsFromDate.el).addClass("cell-range");
						}
					}

					function clearAll() {
						if (jsToDate) {
							$(jsToDate.el).removeClass("cell-range");
						}
						if (jsFromDate) {
							$(jsFromDate.el).removeClass("cell-range");
						}
						jsToDate = null;
						jsFromDate = null;
					}

					var isAdmin = document.getElementById("wpadminbar");
					if (isAdmin && month) {
						var noTime = jQuery.fullCalendar.moment(
							year + "-" + month + "-01"
						);
						$calendar.fullCalendar("gotoDate", noTime);
					}
				}
			},
			error: function(x, y, z) {
				console.log("error", x);
			}
		});
	}

	function buttonAnimate($buttonView) {
		$activeButton = $buttonView;
		$buttonView.addClass("button-animation");
		setTimeout(function() {
			$buttonView.removeClass("button-animation");
		}, 1200);
	}

	function checkStartDate(events, startDate) {
		var result = true;

		for (var i = 0; i < events.length; i++) {
			var event = events[i];
			var startEvent = jQuery.fullCalendar
				.moment(event.start, "YYYY-MM-DD")
				.format("YYYY-MM-DD");
			var endEvent = jQuery.fullCalendar
				.moment(event.end, "YYYY-MM-DD")
				.subtract(1, "days")
				.format("YYYY-MM-DD");

			if (startDate < endEvent && startDate > startEvent) {
				result = false;
				break;
			}
		}

		return result;
	}

	function checkDateRange2(events, startDate, endDate) {
		var result = true;

		for (var i = 0; i < events.length; i++) {
			var event = events[i];
			var startEvent = jQuery.fullCalendar
				.moment(event.start, "YYYY-MM-DD")
				.format("YYYY-MM-DD");
			var endEvent = jQuery.fullCalendar
				.moment(event.end, "YYYY-MM-DD")
				.subtract(1, "days")
				.format("YYYY-MM-DD");

			if (startDate < endEvent && endDate > startEvent) {
				result = false;
				break;
			}
		}

		return result;
	}

	function fillCells() {
		$(`#calendar_${currentCalendarId} .cell-between`).removeClass(
			"cell-between"
		);
		if (jsToDate) {
			$(`#calendar_${currentCalendarId} .fc-day[data-date]`).each(
				function() {
					const $item = $(this);
					const dateStr = $item.data("date");
					if (jsFromDate.d < dateStr && jsToDate.d > dateStr) {
						$item.addClass("cell-between");
					}
				}
			);
		}
	}
});
