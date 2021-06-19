<template>
    <!--begin::Aside-->
    <aside-search @selected-project="handleSelectedProject" />
    <!--end::Aside-->
    <!--begin::List-->
    <div v-if="project != null" class="flex-row-fluid d-flex flex-column ml-lg-8">
        <div class="d-flex flex-column flex-grow-1">
            <!--begin::Card-->
            <div class="card card-custom d-flex flex-grow-1">
                <div class="card-header align-items-center flex-wrap justify-content-between border-0 py-6 h-auto">
                    <!--begin::Left-->
                    <div class="d-flex align-items-center my-2">
                        <div class="d-flex align-items-center flex-column">
                            <template v-if="task == null">

                                <div v-if="loadingPipelines" class="card-spacer-x">
                                    <div class="spinner spinner-primary mr-15 align-self-start"></div>
                                </div>
                                <h3 v-show="!loadingPipelines" class="font-weight-bold mb-0 mr-10 align-self-start">{{ `${project.title}` }}</h3>
                                <span v-show="!loadingPipelines" class="text-muted font-size-sm font-weight-bolder align-self-start mb-4">PROJECT</span>

                                <select v-show="!loadingPipelines" class="form-control form-control-solid select2" id="project-pipelines">
                                    <option value="">Select Pipeline</option>
                                    <option v-for="thisPipeline in pipelines" :key="thisPipeline.id" :value="thisPipeline.id">{{ thisPipeline.title }}</option>
                                </select>
                                <span v-if="pipeline != null" class="text-muted font-size-sm font-weight-bolder align-self-start mb-4 mt-2">PIPELINE</span>
                            </template>
                            <template v-else>
                                <h3 class="font-weight-bold mb-0 mr-10 align-self-start">{{ `${task.title}` }}</h3>
                                <span class="text-muted font-size-sm font-weight-bolder align-self-start mb-4">TASK</span>
                            </template>
                        </div>
                    </div>
                    <!--end::Left-->
                    <!--begin::Right-->
                    <div class="d-flex align-items-center justify-content-end text-right my-2">
                        <template v-if="task">
                            <span @click="handleTaskFormModal" class="btn btn-warning btn-sm text-uppercase font-weight-bolder mr-3">Edit</span>
                            <span @click="handleShowTask(null)" class="btn btn-sm btn-light-primary font-weight-bolder back-btn"><i class="ki ki-long-arrow-back icon-sm"></i> Back</span>
                        </template>
                        <span v-else-if="pipeline" @click="handleTaskFormModal" class="btn btn-light-success btn-sm text-uppercase font-weight-bolder">Add Task</span>
                    </div>
                    <!--end::Right-->
                </div>
                <div class="separator separator-dashed my-2"></div>
                <!--begin::Body-->
                <div class="card-body flex-grow-1">
                    <!--begin::Responsive container-->
                    <div class="row" v-if="!task">
                        <div v-if="loadingTasks || loadingPipelines" class="card-spacer-x">
                            <div class="spinner spinner-primary mr-15"></div>
                        </div>
                        <div v-else class="table-responsive">
                            <div class="list list-hover min-w-500px" >
                                <!--begin::Item-->
                                <div v-for="task in tasks"  @click="handleShowTask(task)" :key="task.id" class="d-flex align-items-start list-item card-spacer-x py-4">
                                    <!--begin::Info-->
                                    <div class="flex-grow-1 mt-1 mr-2" data-toggle="view">
                                        <!--begin::Title-->
                                        <div class="font-weight-bolder mr-2">{{ task.title }}</div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Details-->
                                    <div class="d-flex align-items-center justify-content-end flex-wrap" data-toggle="view">
                                        <!--begin::Datetime-->
                                        <div class="font-weight-bolder" data-toggle="view">{{ task.start_date }} - </div>
                                        <div class="font-weight-bolder" data-toggle="view">{{ task.end_date }}</div>
                                        <!--end::Datetime-->
                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::Item-->
                            </div>
                        </div>
                    </div>
                    <template v-else>
                        <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x card-spacer-x" role="tablist">
                            <li class="nav-item mr-3">
                                <a class="nav-link active" data-toggle="tab" href="#attachments_section">
                                    <span class="nav-icon mr-2">
                                        <span class="svg-icon mr-3">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="nav-text font-weight-bold">Files</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_1">
                                    <span class="nav-icon mr-2">
                                        <span class="svg-icon mr-3">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
                                                    <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="nav-text font-weight-bold">Notes</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-5 card-spacer-x">
                            <!--begin::Tab Content-->
                            <div class="tab-pane active" id="attachments_section" role="tabpanel">
                                <attachments type="task" :id="task.id"></attachments>
                            </div>
                            <!--end::Tab Content-->
                            <!--begin::Tab Content-->
                            <div class="tab-pane" id="kt_apps_projects_view_tab_1" role="tabpanel">
                                <form class="form">
                                    <div class="form-group">
                                        <textarea class="form-control form-control-lg form-control-solid" id="exampleTextarea" rows="3" placeholder="Type notes"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-light-primary font-weight-bold" disabled>Add notes</button>
                                            <a href="#" class="btn btn-clean font-weight-bold">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab Content-->
                        </div>
                    </template>
                    <!--end::Responsive container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>

        <div class="modal fade" :class="{ 'show': showAddTaskModal }"  id="addTaskModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskLabel">Add Task</h5>
                        <button @click.prevent="handleTaskFormModal" type="button" class="close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <vee-form @submit="handlePipelineFormSubmit" :validation-schema="addPipelineSchema" :initial-values="taskEditValues" class="form task-form">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-3">Title</label>
                                <div class="col-9">
                                    <vee-field :value="pipeline != null ? pipeline.title : ''" class="form-control form-control-solid" type="text" name="title" />
                                    <div class="fv-plugins-message-container">
                                        <error-message class="fv-help-block" name="title" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Start Date</label>
                                <div class="col-9">
                                    <vee-field class="form-control form-control-solid" type="date" name="start_date" />
                                    <div class="fv-plugins-message-container">
                                        <error-message class="fv-help-block" name="start_date" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">End Date</label>
                                <div class="col-9">
                                    <vee-field class="form-control form-control-solid" type="date" name="end_date" />
                                    <div class="fv-plugins-message-container">
                                        <error-message class="fv-help-block" name="end_date" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Assign to</label>
                                <div class="col-9">
                                    <vee-field as="select" id="assigned-staff" name="assigned_staff_ids" multiple="multiple" class="form-control form-control-solid select2">

                                    </vee-field>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button @click.prevent="handleTaskFormModal" type="button" class="btn btn-light-primary font-weight-bold">Close</button>
                            <button v-if="isSubmitting" disabled="disabled" type="button" class="btn btn-primary font-weight-bold spinner spinner-white spinner-right">Please wait</button>
                            <button v-else type="submit" class="btn btn-primary font-weight-bold">Save</button>
                        </div>
                    </vee-form>
                </div>
            </div>
        </div>
    </div>
    <!--end::List-->
</template>

<script>
import axios from 'axios'
import { useForm } from 'vee-validate'
import AsideSearch from './AsideSearch.vue'
import Attachments from './Attachments'
import AppTask from './Task.vue'

export default {
    name: 'Tasks',
    data() {
        return {
            project: null,
            pipelines: [],
            tasks: [],
            loadError: false,
            showAddTaskModal: false,
            addPipelineSchema: {
                title: 'required',
                start_date: 'required',
                end_date: 'required',
            },
            assignedStaffToProject: '',
            selectedStaffToAssign: [],
            isSubmitting: false,
            loadingPipelines: false,
            loadingTasks: false,
            showPipeline: false,
            showTask: false,
            pipeline: null,
            task: null,
            taskEditValues: null
        }
    },
    components: {
        AsideSearch,
        Attachments,
        AppTask
    },
    methods: {
        handleSelectedProject(project) {

            if (window.jQuery('#project-pipelines').hasClass("select2-hidden-accessible")) {
                window.jQuery('#project-pipelines').select2('destroy')
            }
            window.jQuery('#project-pipelines').val('').trigger('change')
            this.project = project
            this.assignedStaffToProject = project.assigned_staff_id
            this.task = null
            this.showTask = false
            this.pipeline = null
            this.tasks = null
            this.fetchProjectPipelines()
        },

        async fetchProjectPipelines() {
            this.loadingPipelines = true

            try{
                const res = await axios.get('pipelines', {
                    params: {
                        project_id: this.project.id
                    }
                })
                this.loadError = false
                this.loadingPipelines = false
                this.pipelines = res.data

                if(this.pipeline) {
                    window.jQuery('#project-pipelines').val(this.pipeline.id).trigger('change')
                }

                window.jQuery('#project-pipelines').select2().on('select2:select', (e) => {
                    if(e.params.data.id == '') {
                        this.pipeline = null
                        this.showPipeline = false

                        return
                    }
                    this.pipelines.forEach((value, index) => {
                        if(value.id == e.params.data.id) {
                            this.handleSetPipeline(value)

                            return
                        }
                    })
                })

            } catch(err) {
                this.loadingPipelines = false
                this.loadError = true
                this.tasks = null
            }
        },
        async handlePipelineFormSubmit(values, actions) {
            this.isSubmitting = true
            let url = 'tasks'
            let method = 'POST'

            if(this.task) {
                url = `tasks/${this.task.id}`
                method = 'PUT'
            }

            try{
                const res = await axios.post(url, {
                    title: values.title,
                    start_date: values.start_date,
                    end_date: values.end_date,
                    assigned_staff_ids: this.selectedStaffToAssign,
                    id: this.pipeline.id,
                    type: 'pipeline',
                    _method: method
                })

                if(!this.task) {
                    actions.setValues({
                        title: '',
                        start_date: '',
                        end_date: '',
                    })
                    window.jQuery('#assigned-staff').val('').trigger('change')
                }
                this.isSubmitting = false
                window.$.notify(
                    {
                        title: 'Success',
                        message: `Task ${this.task == null ? 'added' : 'updated'} successfully`,
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
                this.showAddTaskModal = false

                if(this.task) {
                    let currentTask = res.data.pipeline
                    this.pipeline = currentPipeline

                    const pipelineId = this.pipelines.forEach((pipeline, index) => {
                        if(pipeline.id == currentPipeline.id) {
                            this.pipelines[index] = currentPipeline
                        }
                    })

                } else {
                    this.tasks.push(res.data.task)
                }
            } catch(err) {
                this.isSubmitting = false
                window.$.notify(
                        {
                            title: 'Error',
                            message: 'unknown error occurred. please try again later',
                        },
                        {
                            type: 'error',
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
            }
        },
        handleTaskFormModal() {
            this.showAddTaskModal = !this.showAddTaskModal

            if(this.showAddTaskModal) {
                let form = document.getElementsByClassName('task-form')[0]
                form.reset()
                if(this.task) {
                    this.taskEditValues = {
                        title: this.task.title,
                        start_date: this.task.start_date,
                        end_date: this.task.end_date,
                    }
                } else {
                    this.taskEditValues = null
                }

                window.jQuery('#assigned-staff').select2({
                    ajax: {
                    url: 'staff',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'select2'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: (data) => {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.results.filter((item) => {
                                return item.staff_id != this.assignedStaffToProject
                            })
                        };
                    }
                }
                }).on('select2:select', (e) => {
                    this.selectedStaffToAssign.push(e.params.data.id)

                }).on('select2:unselect', (e) => {
                    const index = this.selectedStaffToAssign.indexOf(parseInt(e.params.data.id));
                    if (index > -1) {
                        this.selectedStaffToAssign.splice(index, 1);
                    }

                })
            }
        },

        handleSetPipeline(pipeline) {
            this.pipeline = pipeline
            this.fetchPipelineTasks()
        },

        async fetchPipelineTasks() {
            if(this.pipeline) {
                this.loadingTasks = true
                try{
                    const res = await axios.get('tasks', {
                        params: {
                            pipeline_id: this.pipeline.id
                        }
                    })

                    this.loadError = false
                    this.loadingTasks = false
                    this.tasks = res.data
                } catch(err) {
                    this.loadingTasks = false
                    this.loadError = true
                }
            }
        },

        handleShowTask(task) {
            this.showTask = !this.showTask
            this.task = task

            this.fetchProjectPipelines()
        }
    },
    mounted() {
    },
}
</script>

<style>
    .modal.show {
        display: block;
        overflow-x: hidden;
        overflow-y: auto;
        background-color: rgba(0,0,0,.3);
    }

    .select2.select2-container {
        width: 100% !important
    }
</style>
