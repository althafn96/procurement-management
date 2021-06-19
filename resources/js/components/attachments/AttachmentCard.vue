<template>
    <!--begin::Col-->
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b card-stretch">
            <div class="card-header border-0">
                <h3 class="card-title"></h3>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover py-5">
                                <li class="navi-item">
                                    <a href="javascript:void(0)" @click.prevent="handleAttachmentRemove" class="navi-link">
                                        <span class="navi-text">Remove</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <!--begin: Icon-->
                    <img alt="" class="max-h-65px" :src="thumbImg">
                    <!--end: Icon-->
                    <!--begin: Tite-->
                    <a target="_blank" :href="attachmentImg" class="text-dark-75 font-weight-bold mt-15 font-size-md">{{ attachment.name }}</a>
                    <!--end: Tite-->
                    <span class="text-dark-50 font-weight-bold mt-5 font-size-sm">{{ uploadedDate }}</span>
                </div>
            </div>
        </div>
        <!--end:: Card-->
    </div>
    <!--end::Col-->
</template>

<script>
export default {
    name: 'AttachmentCard',
    props: ['attachment'],
    emits: ['handle-attachment-remove'],
    computed: {
        thumbImg: function() {
            if(this.attachment.extension == 'jpg' || this.attachment.extension == 'png') {
                return `../../storage/${this.attachment.url}`;
            }
            return `../../assets/tenants/media/svg/files/${this.attachment.extension}.svg`;
        },
        attachmentImg: function() {
            return `../../storage/${this.attachment.url}`;
        },
        uploadedDate: function() {
            const date = new Date(this.attachment.created_at)
            return date.toLocaleDateString(undefined, {day: 'numeric', month: 'long', year: 'numeric'})
        }
    },
    methods: {
        handleAttachmentRemove() {
            this.$emit('handle-attachment-remove', this.attachment)
        }
    },
}
</script>

<style>

</style>
