import AdminLayout from '@/Layouts/AdminLayout'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import vSelect from "vue-select"
import 'vue-select/dist/vue-select.css'

export const FormComponentMixin = {

	components: {
        AdminLayout,
        JetFormSection,
        JetInput,
        JetLabel,
        JetInputError,
        JetActionMessage,
        JetButton,
        vSelect
    },
    beforeCreate() {
    	console.log('Hook called from FormComponentMixin.js');
    }
	
}