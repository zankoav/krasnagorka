import {LightningElement, track , api } from 'lwc';
import './stepHouse.scss';

export default class StepHouse extends LightningElement {

    @api settings;
    @track loading;
    @track error;

    async calendarChange(event){
        const id = parseInt(event.detail);
        this.error = false;
        this.loading = true;
        const response = await fetch(`https://krasnagorka.by/wp-json/krasnagorka/v1/ls/house/?calendarId=${id}`)
            .catch(error => {
                console.log('error', error);
            });

        const house = await response.json();
        this.loading = false;
        const newCalendars = this.settings.calendars.map(c => {
            return {...c, selected: c.id === id};
        });
        
        const newMenu = this.settings.menu.map(it => {
            return {
                ...it, 
                available: it.value === 'house'
            };
        });

        const count = parseInt(house.peopleMaxCount);
        const counts = Array.from(Array(count), (_, i) => i + 1).map(it => {
            return { 
                id: it,
                selected: false,
                name: it,
            };
        });

        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                     calendars: newCalendars,
                     house: house,
                     menu: newMenu,
                     counts: counts,
                     dateStart: null,
                     dateEnd: null
                }, 
                 bubbles:true, 
                 composed:true
            })
        );
    }

    countChange(event){
        const id = parseInt(event.detail);
        const newCounts = this.settings.counts.map(c => {
            return {...c, selected: c.id === id};
        });

        const newMenu = this.settings.menu.map(it => {
            return {
                ...it, 
                available: it.value === 'date' ? true : it.available
            };
        });

        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    counts: newCounts,
                    menu: newMenu
                 }, 
                 bubbles:true, 
                 composed:true
             })
         );
         this.error = false;
    }
    
    nextButtonHandler(){
        if(!this.settings.calendars.find(op => op.selected)){
            const selectorCalendars = this.template.querySelector('.step-house__calendars');
            if(selectorCalendars){
                selectorCalendars.showError();
                this.error = 'Выберите домик';
            }
        }else if(!this.settings.counts.find(op => op.selected)){
            const selectorCounts = this.template.querySelector('.step-house__counts');
            if(selectorCounts){
                selectorCounts.showError();
                this.error = 'Выберите количество отдыхающих';
            }
        }else{
            const newMenu = this.settings.menu.map(it => {
                return {...it, active:it.value === 'date'};
            });
            this.dispatchEvent(
                new CustomEvent('update', {
                     detail: {
                        menu: newMenu
                     }, 
                     bubbles:true, 
                     composed:true
                 })
            );
        }
    }
}