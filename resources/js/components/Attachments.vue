<template>
    <!--begin::Row-->
    <div class="row mb-6">
        <file-uploader :type="type" :id="id" :url="attachmentsUrl" @fileUploaded='handleAfterFileUploaded' />
    </div>
    <!--end::Row-->
    <div class="row">
        <attachment-card v-for="attachment in attachments" :attachment="attachment" :key="attachment.id" @handleAttachmentRemove="handleAttachmentRemove(attachment)" />
        <div v-show="loadError">Error in loading files</div>
    </div>
</template>

<script>
import FileUploader from './attachments/FileUploader.vue'
import AttachmentCard from './attachments/AttachmentCard.vue'
import axios from 'axios'

export default {
    name: 'Attachments',
    data() {
        return {
            loading: true,
            attachments: [],
            loadError: false
        }
    },
    props: ['type', 'id'],

    components: {
        FileUploader,
        AttachmentCard
    },

    computed: {
        attachmentsUrl: function() {
            let url = ''
            if(this.type == 'project') {
                url = '../attachments'
            } else if(this.type == 'pipeline') {
                url = 'attachments'
            } else if(this.type == 'task') {
                url = 'attachments'
            }

            return url
        }
    },

    methods: {
        async fetchAttachments() {
            try {

                const res = await axios.get(this.attachmentsUrl, {
                    params: {
                        type: this.type,
                        id: this.id
                    }
                })

                this.attachments = res.data
                this.loadError = false
            } catch(err) {
                console.error(err)
                this.loadError = true
            }
        },
        async handleAttachmentRemove(attachment) {
            try {
                const res = await axios.delete(`${this.attachmentsUrl}/${attachment.id}`)

                if(res.status == 200) {
                    this.attachments.splice(this.attachments.indexOf(attachment), 1);

                    window.$.notify(
                        {
                            title: 'Success',
                            message: 'attachment removed successfully',
                        },
                        {
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: true,
                            mouse_over: true,
                            showProgressbar: false,
                            spacing: 10,
                            timer: 2000,
                            placement: {
                                from: "top",
                                align: "right",
                            },
                            offset: {
                                x: 30,
                                y: 30,
                            },
                            delay: 1000,
                            z_index: 10000,
                            animate: {
                                enter: "animate__animated animate__fadeIn",
                                exit: "animate__animated animate__fadeOut",
                            },
                        }
                    );
                } else {
                    alert('error occurred')
                }
            } catch(err) {
                alert(err)
            }
        },
        async handleAfterFileUploaded() {
            await this.fetchAttachments()
        },
    },
    mounted() {
        this.fetchAttachments()
    },
}
</script>

<style>

</style>
