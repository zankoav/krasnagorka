<?php $model=$args ?>
<!DOCTYPE html>
<html>
    <head>   
        <title> LS primary-desctop </title>
        <style><?= $model->objContent->cssContent?></style>
       <?php wp_head()?>
    </head>
    <body>  
    <header class="header">
         <div class="header__layer">
            <div class="header-widgets container"><a class="header-widgets__logo" href="/"><img
                        class="header-widgets__logo-icon"
                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/logo.8e731a.png"></a>
                <div class="header-widgets__video"><a class="video" href="javascript:void(0);"><img class="video__icon"
                            src="/wp-content/themes/krasnagorka/LS/frontend/src/img/online-video.2386e3.svg"><span
                            class="video__title">смотреть ONLINE</span></a></div>
                <nav class="header-widgets__menu">
                <?php ls_nav_menu() ?>
                    <ul class="menu">
                        <li class="menu__item"><a href="https://krasnagorka.by/">Главная </a></li>
                        <li class="menu__item menu__item-sub-menu"><a
                                href="https://krasnagorka.by/dom-na-braslavskih-ozyorah/">Наши дома</a>
                            <ul class="menu__sub-menu">
                                <li class="menu__item"><a href="https://krasnagorka.by/">Бунгало </a></li>
                                <li class="menu__item"><a href="https://krasnagorka.by/">Домик у причала </a></li>
                                <li class="menu__item menu__item_active"><a href="https://krasnagorka.by/">Рыбацкий </a>
                                </li>
                                <li class="menu__item"><a href="https://krasnagorka.by/">Датский </a></li>
                                <li class="menu__item"><a href="https://krasnagorka.by/">Бабочка </a></li>
                                <li class="menu__item"><a href="https://krasnagorka.by/">Божья коровка </a></li>
                                <li class="menu__item"><a href="https://krasnagorka.by/">Пилигрим </a></li>
                            </ul>
                        </li>
                        <li class="menu__item"><a href="https://krasnagorka.by/">Услуги и развлечения </a></li>
                        <li class="menu__item"><a href="https://krasnagorka.by/">Цены</a></li>
                        <li class="menu__item menu__item_active"><a href="https://krasnagorka.by/">Мероприятия</a></li>
                        <li class="menu__item"><a href="https://krasnagorka.by/">Схема проезда</a></li>
                        <li class="menu__item"><a href="https://krasnagorka.by/">Календарь бронирования</a></li>
                    </ul>
                </nav>
                <div class="header-widgets__contacts">
                    <div class="contacts">
                        <div class="contacts__link"><img class="contacts__icon"
                                src="/wp-content/themes/krasnagorka/LS/frontend/src/img/contacts-icon.d9f04b.svg"></div>
                        <div class="contacts__popup">
                            <div class="contacts__item contacts__item_messangers"><img class="contacts__messanger"
                                    src="/wp-content/themes/krasnagorka/LS/frontend/src/img/viber.71338d.svg"><img
                                    class="contacts__messanger"
                                    src="/wp-content/themes/krasnagorka/LS/frontend/src/img/whatsapp.4df22a.svg"><img
                                    class="contacts__messanger"
                                    src="/wp-content/themes/krasnagorka/LS/frontend/src/img/telegram.867f4f.svg"><a
                                    class="contacts__action-item" href="tel:<?$model->contact->a1?>"><img
                                        class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/a1.93791f.png"><span
                                        class="contacts__phone"><?=$model->contact->a1?></span></a></div>
                            <div class="contacts__item"><a class="contacts__action-item" href="tel:<?=$model->contact->mts?>">
                                    <img class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/mts.0ba57a.svg"><span
                                        class="contacts__phone"><?=$model->contact->mts?></span></a></div>
                            <div class="contacts__item"><a class="contacts__action-item" href="tel:<?=$model->contact->life?>">
                                    <img class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/life.4c7b3c.svg"><span
                                        class="contacts__phone"><?=$model->contact->life?></span></a></div>
                            <div class="contacts__item contacts__item_email"><a class="contacts__action-item"
                                    href="mailto:<?=$model->contact->email?>"> <img class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/envelope.af497d.svg"><span
                                        class="contacts__email"><?=$model->contact->email?></span></a></div>
                            <div class="contacts__item">
                                <div class="contacts__action-item"><img class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/clock.1fa375.svg"><span
                                        class="contacts__time">9:00 - 20:00 пн-пт</span></div>
                            </div>
                            <div class="contacts__item">
                                <div class="contacts__action-item"><img class="contacts__item-img"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/clock.1fa375.svg"><span
                                        class="contacts__time">11:00 - 20:00 сб,вс</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-widgets__view"></div>
                <div class="header-widgets__currencies">
                    <div class="currencies" data-title="Выберите валюту">
                        <div class="currencies__wrapper">
                            <div class="currencies__current" data-currency="byn"><img class="currencies__flag"
                                    src="/wp-content/themes/krasnagorka/LS/frontend/src/img/byn.8ed77d.svg"></div>
                            <ul class="currencies__list">
                                <li class="currencies__item" data-currency="byn"><img class="currencies__flag"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/byn.8ed77d.svg"></li>
                                <li class="currencies__item" data-currency="rub"><img class="currencies__flag"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/rub.7a8b3a.svg"></li>
                                <li class="currencies__item" data-currency="usd"><img class="currencies__flag"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/usd.aefba3.svg"></li>
                                <li class="currencies__item" data-currency="eur"><img class="currencies__flag"
                                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/eur.7b4534.svg"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-widgets__weather">
                    <div class="today" data-mounth="<?=$model->today->month?>"><?=$model->today->day ?></div>
                    <div class="header-widgets__weather-block">
                        <div class="weather">
                            <div class="weather__today" data-description="<?= $model->weather->description?>"><img
                                    class="weather__today-img" src="<?= $model->weather->icon?>"
                                    alt="<?=$model->weather->icon?>"></div>
                            <div class="weather__today-degree"><?=$model->weather->temperature?></div>
                            <div class="weather__day" data-day="<?=$model->weather->firstDay->day?>"><img class="weather__day-img"
                                    src="<?=$model->weather->firstDay->icon?>" alt="<?=$model->weather->firstDay->icon?>"></div>
                            <div class="weather__day" data-day="<?=$model->weather->secondDay->day?>"><img class="weather__day-img"
                                    src="<?=$model->weather->secondDay->icon?>" alt="<?=$model->weather->secondDay->icon?>"></div>
                            <div class="weather__day" data-day="<?=$model->weather->thirdDay->day?>"><img class="weather__day-img"
                                    src="<?=$model->weather->thirdDay->icon?>" alt="<?=$model->weather->thirdDay->icon?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__layer">
            <div class="slider">
                <div class="slider__wrapper">
                    <div class="slider__item"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2019/06/DSC2166-1280x852.jpg"
                            alt="slide name">
                        <p class="slider__item-title">База отдыха на Браславских озерах</p>
                        <p class="slider__item-description">Место, куда хочется возвращаться!</p><a class="button"
                            href="javascript:void(0);">Смотреть все предложения</a>
                    </div>
                    <div class="slider__item"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2017/10/DSC5471.jpg" alt="slide name">
                        <p class="slider__item-title">Уют и комфорт в каждом домике!</p>
                        <p class="slider__item-description">Варианты размещения для любой компании. Вместимость базы до
                            90 спальных мест</p><a class="button" href="javascript:void(0);">Смотреть все
                            предложения</a>
                    </div>
                    <div class="slider__item"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2021/01/DSC0252-1280x852.jpg"
                            alt="slide name">
                        <p class="slider__item-title">Развлечения для любого возраста</p>
                        <p class="slider__item-description">Спортивные и уединенные, активные и для любителей тишины и
                            релакса.</p><a class="button" href="javascript:void(0);">Смотреть все предложения</a>
                    </div>
                    <div class="slider__item"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2015/02/DSC1304.jpg" alt="slide name">
                        <p class="slider__item-title">Горящие предложения на ближайшие даты!</p>
                        <p class="slider__item-description"></p><a class="button" href="javascript:void(0);">Смотреть
                            все предложения</a>
                    </div>
                </div>
            </div>
        </div>
    
    </header>
	
