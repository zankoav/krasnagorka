<?php
    $model=$args;
?>
<!DOCTYPE html>
<html>
    <head>   
        <title> LS primary-desctop </title>
        <style><?= $model->objContent->cssContent?></style>
       <?php wp_head();?>
    </head>
    <body>  
    <header class="header">
         <div class="header__layer">
            <div class="header-widgets container"><a class="header-widgets__logo" href="/"><img
                        class="header-widgets__logo-icon"
                        src="/wp-content/themes/krasnagorka/LS/frontend/src/img/logo.8e731a.png"></a>
                <div class="header-widgets__video"><a class="video" href="https://public.ivideon.com/embed/v3/?server=100-Zkn8nBIwRPePMTeUfZtRVW&camera=0&width=&height=&lang=ru"><img class="video__icon"
                            src="/wp-content/themes/krasnagorka/LS/frontend/src/img/online-video.2386e3.svg"><span
                            class="video__title">смотреть ONLINE</span></a></div>
                <nav class="header-widgets__menu">
                    <?php ls_nav_menu(); ?>
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
                            <div class="currencies__current" data-currency=<?=$model->currency->abbreviation;?>><img class="currencies__flag"
                                    src="<?=$model->currency->image;?>"></div>
                            <ul class="currencies__list">
                                <li class="currencies__item" data-currency="<?=LS_Currency::BYN;?>">
                                    <img class="currencies__flag"
                                        src="<?=LS_Currency::getImage(LS_Currency::BYN);?>">
                                </li>
                                <li class="currencies__item" data-currency="<?=LS_Currency::RUB;?>">
                                    <img class="currencies__flag"
                                        src="<?=LS_Currency::getImage(LS_Currency::RUB);?>">
                                </li>
                                <li class="currencies__item" data-currency="<?=LS_Currency::USD;?>">
                                    <img class="currencies__flag"
                                        src="<?=LS_Currency::getImage(LS_Currency::USD);?>">
                                </li>
                                <li class="currencies__item" data-currency="<?=LS_Currency::EUR;?>">
                                    <img class="currencies__flag"
                                        src="<?=LS_Currency::getImage(LS_Currency::EUR);?>">
                                </li>
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
                <div class="slider__nav">
                    <div class="slider__nav-inner">
                        <div class="slider__next"></div>
                        <div class="slider__prev"></div>
                    </div>
                </div>
                <div class="slider__wrapper slider-main">
                    <div class="slider__item slide-js"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2019/06/DSC2166-1280x852.jpg"
                            alt="slide name">
                        <p class="slider__item-title">База отдыха на Браславских озерах</p>
                        <p class="slider__item-description">Место, куда хочется возвращаться!</p><a class="button"
                            href="javascript:void(0);">Смотреть все предложения</a>
                    </div>
                    <div class="slider__item slide-js"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2017/10/DSC5471.jpg" alt="slide name">
                        <p class="slider__item-title">Уют и комфорт в каждом домике!</p>
                        <p class="slider__item-description">Варианты размещения для любой компании. Вместимость базы до
                            90 спальных мест</p><a class="button" href="javascript:void(0);">Смотреть все
                            предложения</a>
                    </div>
                    <div class="slider__item slide-js"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2021/01/DSC0252-1280x852.jpg"
                            alt="slide name">
                        <p class="slider__item-title">Развлечения для любого возраста</p>
                        <p class="slider__item-description">Спортивные и уединенные, активные и для любителей тишины и
                            релакса.</p><a class="button" href="javascript:void(0);">Смотреть все предложения</a>
                    </div>
                    <div class="slider__item slide-js"><img class="slider__item-img"
                            src="https://krasnagorka.by/wp-content/uploads/2015/02/DSC1304.jpg" alt="slide name">
                        <p class="slider__item-title">Горящие предложения на ближайшие даты!</p>
                        <p class="slider__item-description"></p><a class="button" href="javascript:void(0);">Смотреть
                            все предложения</a>
                    </div>
                </div>
            </div>
        </div>
    
    </header>
	
