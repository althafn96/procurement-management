import { createApp } from 'vue'
import Attachments from './components/Attachments.vue'
import Pipelines from './components/Pipelines.vue'
import Tasks from './components/Tasks.vue'
import VeeValidatePlugin from './plugins/validation'

if(document.getElementById("attachments_section")) {
    const appAttachmentsSection = createApp({})
    appAttachmentsSection.component('app-attachments', Attachments)
    appAttachmentsSection.mount('#attachments_section')
}

if(document.getElementById("pipelines_section")) {
    const appPipelinesSection = createApp({})
    appPipelinesSection.component('app-pipelines', Pipelines)
    appPipelinesSection.use(VeeValidatePlugin)
    appPipelinesSection.mount('#pipelines_section')
}

if(document.getElementById("tasks_section")) {
    const appTasksSection = createApp({})
    appTasksSection.component('app-tasks', Tasks)
    appTasksSection.use(VeeValidatePlugin)
    appTasksSection.mount('#tasks_section')
}
