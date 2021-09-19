<template>
    <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="userModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-xxl modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalTitle">Create a new user</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body addUser">
                    <div class="row">
                        <form-wizard>
                            <tab-content title="Personal details">
                                My first tab content
                            </tab-content>
                            <tab-content title="Additional Info">
                                My second tab content
                            </tab-content>
                            <tab-content title="Last step">
                                Yuhuuu! This seems pretty damn simple
                            </tab-content>
                        </form-wizard>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
export default {
    components:{FormWizard,TabContent},
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>
