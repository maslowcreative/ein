<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Invoices/Claims</h5>
                    <small class="text-primary">9999 Invoices/Claims</small>
                </div>
                <div class="card-right-btns">
                    <button class="btn btn-primary">All Claims</button>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false">Pending Approval</button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </div>
                    </div>
                    <button class="btn btn-light btn-icon">
                        <ion-icon name="funnel-outline"></ion-icon>
                    </button>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Claim Number</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" aria-label="...">
                        </td>
                        <td>
                            <div class="fw-bold">
                                Claim #12131
                                <span class="d-block text-primary fw-normal">Provider’s Name</span>
                            </div>
                        </td>
                        <td>
                            Claim Status
                        </td>
                        <td><button class="btn btn-light btn-sm">View more</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="document-attach-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" aria-label="...">
                        </td>
                        <td>
                            <div class="fw-bold">
                                Claim #12131
                                <span class="d-block text-primary fw-normal">Provider’s Name</span>
                            </div>
                        </td>
                        <td>
                            Claim Status
                        </td>
                        <td><button class="btn btn-light btn-sm">View more</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="document-attach-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" aria-label="...">
                        </td>
                        <td>
                            <div class="fw-bold">
                                Claim #12131
                                <span class="d-block text-primary fw-normal">Provider’s Name</span>
                            </div>
                        </td>
                        <td>
                            Claim Status
                        </td>
                        <td><button class="btn btn-light btn-sm">View more</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="document-attach-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" aria-label="...">
                        </td>
                        <td>
                            <div class="fw-bold">
                                Claim #12131
                                <span class="d-block text-primary fw-normal">Provider’s Name</span>
                            </div>
                        </td>
                        <td>
                            Claim Status
                        </td>
                        <td><button class="btn btn-light btn-sm">View more</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="document-attach-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" aria-label="...">
                        </td>
                        <td>
                            <div class="fw-bold">
                                Claim #12131
                                <span class="d-block text-primary fw-normal">Provider’s Name</span>
                            </div>
                        </td>
                        <td>
                            Claim Status
                        </td>
                        <td><button class="btn btn-light btn-sm">View more</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="document-attach-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-end mt-5">
                    <button class="btn btn-primary">Download Selected</button>
                    <button class="btn btn-light">Upload Selected</button>
                </div>
                <div class="mt-5">
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
