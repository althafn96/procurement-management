<template>
    <div class="col-lg-12">
        <file-pond
            name="file"
            ref="pond"
            label-idle="Drop files here..."
            v-bind:allow-multiple="true"
            v-bind:allow-file-type-validation="false"
            :server="{
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                process: {
                    ondata: (formData) => {
                        formData.append('type', type);
                        formData.append('id', id);
                        return formData;
                    },
                }
            }"
        />
    </div>
</template>

<script>
// Import Vue FilePond
import vueFilePond, { setOptions } from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);


export default {
    name: "FileUploader",
    props: ['type', 'id', 'url'],
    data() {
        return {
            csrfToken: ''
        };
    },
    emits: ['file-uploaded'],
    components: {
        FilePond,
    },
    mounted() {
        this.csrfToken = document.querySelector('[name="csrf-token"]').getAttribute('content')

        setOptions({
            'allowRevert': false,
            'onprocessfile': async (error, file) => {
                if(error == null) {
                    await this.$emit('file-uploaded')
                    setTimeout(() => {
                        this.$refs.pond.removeFile(file)
                    }, 1500);
                }
            }
        })
    }
};
</script>

<style>
    .filepond--credits {
        display: none;
    }
</style>
