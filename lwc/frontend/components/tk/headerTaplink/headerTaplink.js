/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './headerTaplink.scss'
import PHONE_ICON from './../../../icons/contacts-icon.svg'

export default class HeaderTaplink extends LightningElement {
    @api model
    contactIcon = PHONE_ICON
    contactsPopupIsOpen

    get contactsModel() {
        return {
            footerBottom: {
                socials: this.model.socials
            },
            popupContacts: this.model.info
        }
    }

    renderedCallback() {
        var canvas = this.template.querySelector('canvas')
        var ctx = canvas.getContext('2d')

        canvas.width = window.innerWidth
        canvas.height = window.innerHeight

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth
            canvas.height = window.innerHeight
        })

        var date = Date.now()

        function draw(delta) {
            requestAnimationFrame(draw)
            canvas.width = canvas.width
            var my_gradient = ctx.createLinearGradient(0, 0, 0, canvas.height / 2)
            my_gradient.addColorStop(0, 'rgba(80, 157, 159, 0.75)')
            my_gradient.addColorStop(1, 'rgba(21, 139, 194, 0.75)')
            ctx.fillStyle = my_gradient

            var randomLeft = Math.abs(Math.pow(Math.sin(delta / 1000), 2)) * 100
            var randomRight = Math.abs(Math.pow(Math.sin(delta / 1000 + 10), 2)) * 100
            var randomLeftConstraint = Math.abs(Math.pow(Math.sin(delta / 1000 + 2), 2)) * 100
            var randomRightConstraint = Math.abs(Math.pow(Math.sin(delta / 1000 + 1), 2)) * 100

            ctx.beginPath()
            ctx.moveTo(0, randomLeft)

            // ctx.lineTo(canvas.width, randomRight);
            ctx.bezierCurveTo(
                canvas.width / 3,
                randomLeftConstraint,
                (canvas.width / 3) * 2,
                randomRightConstraint,
                canvas.width,
                randomRight
            )
            ctx.lineTo(canvas.width, canvas.height)
            ctx.lineTo(0, canvas.height)
            ctx.lineTo(0, randomLeft)

            ctx.closePath()
            ctx.fill()
        }
        requestAnimationFrame(draw)
    }

    toggleContacts() {
        this.contactsPopupIsOpen = !this.contactsPopupIsOpen
    }
}
