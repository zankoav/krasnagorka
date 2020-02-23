$.noConflict();
jQuery(document).ready(function($) {
	console.log("jquery is ready", $);
});

var targetMargin, scriptFullCalendar, scriptLocalCalendar, month, $activeButton;
var year = new Date().getFullYear();
var _startDate = "";
var _endDate = "";
var _title = "Терем";

var jsFromDate, jsToDate, currentCalendarId;

jQuery(".booking-houses__calendars-button, .our-house__button-booking").on(
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
	var calendarShortcod = jQuery(this).data("calendar");
	var attArray = calendarShortcod.split('"');
	var data = {
		action: "calendar_action",
		id: attArray[1],
		slug: attArray[3]
	};
	var $parent = jQuery(this)
		.parent()
		.parent()
		.parent()
		.find(".booking-houses__calendars-inner");
	var $title = jQuery(this)
		.parent()
		.parent()
		.parent()
		.find(".booking-houses__title");
	var $parentDate = jQuery(this)
		.parent()
		.parent()
		.parent()
		.find(".our-house__date");
	var $orderButton = jQuery(this)
		.parent()
		.parent()
		.parent()
		.find(
			".our-house__button[data-name], .house-booking__button[data-name]"
		);
	if (!$orderButton.length) {
		$orderButton = jQuery("[data-name]");
	}
	var $teremButton = jQuery(".terem-button");
	var $orderBookingButton = jQuery(this)
		.parent()
		.parent()
		.find(".our-house__button-hidden");
	var $textHelper;
	var events;

	function setDate() {
		const msg = $textHelper.data("helper-start");
		jQuery(".select-helper__text")
			.removeClass("select-helper__text_success")
			.html(msg);

		jQuery("[data-name]").each(function(index) {
			const item = jQuery(this);
			const bookingId = jQuery(item).data("id");
			const calendarId = jQuery(item).data("cd");
			const title = jQuery(item).data("name");
			let baseHref = `/booking-form/?booking=${bookingId}&calendarId=${calendarId}`;
			if (jQuery(item).hasClass("is-terem-js")) {
				baseHref += `&terem=${title}`;
			}
			jQuery(item).attr("href", baseHref);
		});

		if ($teremButton.length) {
			const bookingId = jQuery($teremButton[0]).data("id");
			const baseHref = `/booking-form/?booking=${bookingId}`;
			jQuery($teremButton[0]).attr("href", baseHref);
		}
	}
	jQuery(this).remove();

	jQuery.ajax(kg_ajax.url, {
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
							var cielWidth = jQuery(
								jQuery(".fc-day-top")[0]
							).width();
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
								style.appendChild(document.createTextNode(css));
							}
						}
						1 == r
							? $calendar.children("#cloader").show()
							: $calendar.children("#cloader").hide();
					},
					locale: "ru",
					// selectable: true,
					// selectHelper: true,
					// selectLongPressDelay: 600,
					header: { left: "prev", center: "title", right: "next" },
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
								jsFromDate = { d: jsFromDate.d, el: element };
								jQuery(jsFromDate.el)
									.css("background-color", "#bce8f1")
									.empty()
									.append(createButtonFrom(true));
							}
						}

						if (jsToDate) {
							var element = document.querySelector(
								`#calendar_${currentCalendarId}  .fc-widget-content[data-date="${jsToDate.d}"]`
							);
							if (element) {
								jsToDate = { d: jsToDate.d, el: element };
								jQuery(jsToDate.el)
									.css("background-color", "#bce8f1")
									.empty()
									.append(createButtonFrom());
							}
						}
					},
					dayClick: function(date, jsEvent, view) {
						setDate();
						var d = date.format("YYYY-MM-DD");
						if (!currentCalendarId) {
							currentCalendarId = data.id;
							initFrom(d, this);
						} else if (currentCalendarId != data.id) {
							clearAll();
							currentCalendarId = data.id;
							initFrom(d, this);
						} else {
							if (!jsFromDate) {
								initFrom(d, this);
							} else if (jsFromDate && jsFromDate.d === d) {
								clearAll();
							} else if (
								jsFromDate &&
								!jsToDate &&
								jsFromDate.d < d &&
								checkDateRange2(events, jsFromDate.d, d)
							) {
								jsToDate = { d: d, el: this };
								jQuery(jsToDate.el)
									.css("background-color", "#bce8f1")
									.append(createButtonFrom());
							} else if (
								jsFromDate &&
								jsToDate &&
								jsToDate.d !== d &&
								jsFromDate.d < d &&
								checkDateRange2(events, jsFromDate.d, d)
							) {
								jQuery(jsToDate.el)
									.css("background-color", "initial")
									.empty();
								jsToDate = { d: d, el: this };
								jQuery(jsToDate.el)
									.css("background-color", "#bce8f1")
									.append(createButtonFrom());
							} else if (jsToDate && jsToDate.d === d) {
								jQuery(jsToDate.el)
									.css("background-color", "initial")
									.empty();
								jsToDate = null;
							}
						}

						if (jsFromDate && jsToDate) {
							$textHelper
								.addClass("select-helper__text_success")
								.html(
									`Дата бронирования:<br>${jsFromDate.d} &mdash; ${jsToDate.d}`
								);
							buttonAnimate($orderButton);

							const bookingId = jQuery($orderButton[0]).data(
								"id"
							);
							const calendarId = jQuery($orderButton[0]).data(
								"cd"
							);

							let baseHref = `/booking-form/?booking=${bookingId}&calendarId=${calendarId}&from=${jsFromDate.d}&to=${jsToDate.d}`;
							if (
								jQuery($orderButton[0]).hasClass("is-terem-js")
							) {
								const titleTerem = jQuery($orderButton[0]).data(
									"name"
								);
								baseHref += `&terem=${titleTerem}`;
							}
							jQuery($orderButton[0]).attr("href", baseHref);
							if ($orderButton[1]) {
								jQuery($orderButton[1]).attr("href", baseHref);
							}
						} else if (jsFromDate) {
							$textHelper
								.removeClass("select-helper__text_success")
								.html(`Заезд: ${jsFromDate.d}`);
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
						jQuery(jsFromDate.el)
							.css("background-color", "#bce8f1")
							.append(createButtonFrom(true));
					}
				}

				function clearAll() {
					if (jsToDate) {
						jQuery(jsToDate.el)
							.css("background-color", "initial")
							.empty();
					}
					if (jsFromDate) {
						jQuery(jsFromDate.el)
							.css("background-color", "initial")
							.empty();
					}
					jsToDate = null;
					jsFromDate = null;
				}

				function createButtonFrom(isFrom) {
					var wrapper = document.createElement("div");
					wrapper.setAttribute(
						"style",
						"transform: translateY(100%);color:#d0021b;"
					);
					wrapper.innerHTML = isFrom ? "Заезд" : "Выезд";
					return wrapper;
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

function checkDateRange(events, startDate, endDate) {
	var result = true;

	if (startDate > endDate) {
		var tempDate = startDate;
		startDate = endDate;
		endDate = tempDate;
	}

	for (var i = 0; i < events.length; i++) {
		var event = events[i];
		var startEvent = jQuery.fullCalendar
			.moment(event.start, "YYYY-MM-DD")
			.add(1, "day")
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

jQuery(".booking-houses__calendars-all-button").on("click", function(event) {
	event.preventDefault();
	jQuery(".booking-houses__calendars-button").trigger("click");
	jQuery(this).remove();
	month = jQuery("#admin-month option:selected").val();
	jQuery("#admin-month").remove();
	year = jQuery("#admin-years option:selected").val();
	jQuery("#admin-years").remove();
});
