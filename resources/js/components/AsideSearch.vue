<template>
    <div class="flex-row-auto offcanvas-mobile" :class="[pipelinesProject == null ? 'w-100' : 'w-200px w-xxl-275px']">
        <!--begin::Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Body-->
            <div class="card-body px-5">
                <!--begin:Nav-->
                <div class="navi navi-hover navi-active navi-link-rounded navi-bold navi-icon-center navi-light-icon">
                    <!--begin:Item-->
                    <div class="navi-item my-2">
                        <div class="quick-search quick-search-dropdown">
                            <!--begin:Form-->
                            <form class="quick-search-form">
                                <div class="input-group" :class="{ 'spinner spinner-primary spinner-right': searchLoading }">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="svg-icon svg-icon-lg">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path
                                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </div>
                                    <input v-model="searchTerm" @keyup="handleSearchInput" type="text" class="form-control" placeholder="Search Project..." />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="quick-search-close ki ki-close icon-sm text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <span v-if="searchTerm != ''" class="font-size-sm" style="padding: 1rem 1.5rem">
                            search results for {{ searchTerm }}
                        </span>
                    </div>
                    <!--end:Item-->
                    <!--begin:Item-->
                    <div v-for="result in searchResults" class="navi-item my-2">
                        <a href="javascript:void(0)" @click="handleProjectSelect(result)" class="navi-link d-flex flex-column">
                            <span class="navi-text font-weight-bolder font-size-lg align-self-start">{{ result.title }}</span>
                            <span class="navi-text font-weight-muted text-dark-50 font-size-md align-self-start">{{ result.reference_no }}</span>
                        </a>
                    </div>
                    <!--end:Item-->
                    <div v-if="searchTerm != ''" class="separator separator-dashed my-10"></div>
                    <!--begin:Section-->
                    <div class="navi-section mt-7 mb-2 font-size-h6 font-weight-bold pb-0">Recent Projects</div>
                    <!--end:Section-->
                    <!--begin:Item-->
                    <div v-for="project in recentProjects" class="navi-item my-2">
                        <a href="javascript:void(0)" @click="handleProjectSelect(project)" class="navi-link">
                            <span class="navi-icon mr-4">
                                <span class="svg-icon svg-icon-lg">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <template class="d-flex flex-column">
                                <span class="navi-text font-weight-bolder font-size-lg align-self-start">{{ project.title }}</span>
                                <span class="navi-text font-weight-muted text-dark-50 font-size-md align-self-start">{{ project.reference_no }}</span>
                            </template>
                        </a>
                    </div>
                    <!--end:Item-->
                </div>
                <!--end:Nav-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'

export default {
    name: 'AsideSearch',
    data() {
        return {
            searchResults: [],
            recentProjects: [],
            loading: true,
            searchTerm: '',
            searchLoading: false,
            pipelinesProject: null
        }
    },
    emits: ['selectedProject'],
    methods: {
        async fetchRecentProjects() {

            try {
                const res = await axios.get('projects', {
                    params: {
                        type: 'recent'
                    }
                })

                this.recentProjects = res.data
                this.loading = false
            } catch(err) {
                console.error(err)
                this.loading = true
            }

        },
        handleSearchInput() {
            this.searchLoading = true
            this.fetchSearchResults()
        },
        fetchSearchResults:  _.debounce(async function(){

            if(this.searchTerm == '') {
                this.searchResults = []
                this.searchLoading = false
            } else {
                try {
                    const res = await axios.get('projects', {
                        params: {
                            searchTerm: this.searchTerm
                        }
                    })

                    this.searchResults = res.data
                    this.searchLoading = false
                } catch(err) {
                    console.error(err)
                    this.searchLoading = false
                }
            }
        }, 500),

        handleProjectSelect(project) {
            this.$emit('selectedProject', project)
            this.pipelinesProject = project
        }
    },
    created() {
        this.fetchRecentProjects()
    },
}
</script>

<style>

</style>
