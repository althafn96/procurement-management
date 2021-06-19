import { Form as VeeForm, Field as VeeField, defineRule, ErrorMessage, configure } from 'vee-validate'
import { required } from '@vee-validate/rules'

export default {
    install(app) {
        app.component('VeeForm', VeeForm)
        app.component('VeeField', VeeField)
        app.component('ErrorMessage', ErrorMessage)

        defineRule('required', required)

        configure({
            generateMessage: (ctx) => {
                const messages = {
                    required: `${ctx.field.replace('_', ' ')} is required`
                }

                const message = messages[ctx.rule.name] ? messages[ctx.rule.name] : `${ctx.field} is required`

                return message
            }
        })
    },
}
