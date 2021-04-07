@extends('layouts.app')

@section('title')
    Expense Category
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
        <li class="breadcrumb-item"><a href="#">Expense Management</a></li>
        <li class="breadcrumb-item active" aria-current="page">Expenses Category</li>
    </ol>
</nav>
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto mb-3">
                    <button type="button" class="btn text-white btn-success" data-bs-toggle="modal"
                        data-bs-target="#categoryModal" @click="overview = {
                            name: '',
                            description: ''
                        }">
                        Add Category
                    </button>
                </div>
                <div class="col-12 overflow-scroll">
                    <table id="categories-table" class="table table-hover"></table>
                </div>
            </div>
        </div>
        <!-- Expense Category Update Modal -->
        <div class="modal fade" id="categoryUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Display Name</label>
                                <input class="form-control" v-model="overview.name">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" v-model="overview.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger me-xs-1" @click="destroy"
                            style="margin-right: 250px; important!" data-bs-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="update"
                            data-bs-dismiss="modal">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Expense Category Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Display Name</label>
                                <input class="form-control" v-model="overview.name">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" v-model="overview.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="store">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const e = new Vue({
            el: '#app',
            data: {
                dt: null,
                myModal: null,
                overview: {
                    name: '',
                    description: '',
                },
            },
            methods: {
                destroy() {
                    var $this = this;
                    axios.delete(this.overview.destroy_link, this.overview)
                        .then(params => {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        })
                        .catch(excp => {
                            catchError(excp);
                        }).then(params => {
                            $this.overview = {
                                name: '',
                                description: ''
                            };
                            $this.dt.draw();
                        });
                },
                update() {
                    var $this = this;
                    axios.put(this.overview.update_link, this.overview)
                        .then(params => {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        })
                        .catch(excp => {
                            catchError(excp);
                        }).then(params => {
                            $this.overview = {
                                name: '',
                                description: ''
                            };
                            $this.dt.draw();
                        });
                },
                store() {
                    var $this = this;
                    axios.post('{{ route('categories.store') }}', this.overview)
                        .then(params => {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        })
                        .catch(excp => {
                            catchError(excp);
                        }).then(params => {
                            $this.overview = {
                                name: '',
                                description: ''
                            };
                            $this.dt.draw();
                        });
                }
            },
            mounted() {
                var $this = this;

                var myModal = new bootstrap.Modal(document.getElementById('categoryUpdateModal'), {
                    keyboard: false
                });

                $this.dt = $('#categories-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('categories.table') }}',
                        type: 'POST'
                    },
                    order: [2, 'desc'],
                    columns: [{
                            data: 'name',
                            title: 'Display Name'
                        },
                        {
                            data: 'description',
                            title: 'Description'
                        },
                        {
                            data: 'created_at',
                            title: 'Date Created'
                        },
                    ],
                    "drawCallback": function(settings) {
                        $('tbody').on('click', 'tr', function() {
                            $this.overview = $this.dt.row(this).data();
                            myModal.show();
                        });
                    }
                });
            }
        });

    </script>
@endsection
