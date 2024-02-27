/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, track } from 'lwc'
import { getMonthTodayRu, getDayNumberToday } from '../utils/utils'
import './place.scss'

export default class Place extends LightningElement {
    @track day = getDayNumberToday()
    @track month = getMonthTodayRu()
}
