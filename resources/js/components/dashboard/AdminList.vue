<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Sub-Admins</h5>
                    <small class="text-primary">99999 Sub-admins</small>
                </div>
                <div class="card-right-btns">
                    <button class="btn btn-primary btn-icon">
                        <ion-icon name="add-outline"></ion-icon> Add New Admin
                    </button>
                    <button class="btn btn-light btn-icon">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>
            </div>
            <div class="table-x-scroll">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="not-center">Sub-Admin</th>
                        <th scope="col">Enable/Disable Admin</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="not-center">
                            <div class="d-flex">
                                <div class="me-4">
                                    <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                                </div>
                                <div class="fw-bold">
                                    Sub-admin Name
                                    <span class="d-block text-primary fw-normal">Participant</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-inline-block">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                                <button class="btn btn-link p-0 fs-16 mx-1">
                                    <ion-icon name="options-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 mt-md-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">100</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>
