@extends('layouts.app')

@section('title')
    Expenses
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
        <li class="breadcrumb-item"><a href="#">Expense Management</a></li>
        <li class="breadcrumb-item active" aria-current="page">Expenses</li>
    </ol>
</nav>
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto mb-3">
                    <button type="button" class="btn text-white btn-success" data-bs-toggle="modal"
                        data-bs-target="#expenseModal" @click="overview = {
                            expense_category_id: '',
                            amount: '',
                            entry_date: ''
                        }">
                        Add Category
                    </button>
                </div>
                <div class="col-12 overflow-scroll">
                    <table id="expense-table" class="table table-hover"></table>
                </div>
            </div>
        </div>
        <!-- Expense Update Modal -->
        <div class="modal fade" id="expenseUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Expense Category</label>
                                <select class="form-select" v-model="overview.expense_category_id">
                                    <option v-for="item in categories" v-bind:value="item.id">@{{ item.name }}</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Amount</label>
                                <input class="form-control" v-model="overview.amount" type="number">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Entry Date</label>
                                <input class="form-control" v-model="overview.entry_date" type="date">
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
        <!-- Expense Modal -->
        <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Expense Category</label>
                                <select class="form-select" v-model="overview.expense_category_id">
                                    <option v-for="item in categories" v-bind:value="item.id">@{{ item.name }}</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Amount</label>
                                <input class="form-control" v-model="overview.amount" type="number">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Entry Date</label>
                                <input class="form-control" v-model="overview.entry_date" type="date">
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
                categories: {!! $categories !!},
                overview: {
                    expense_category_id: '',
                    amount: '',
                    entry_date: ''
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
                                expense_category_id: '',
                                amount: '',
                                entry_date: ''
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
                                expense_category_id: '',
                                amount: '',
                                entry_date: ''
                            };
                            $this.dt.draw();
                        });
                },
                store() {
                    var $this = this;
                    axios.post('{{ route('expense.store') }}', this.overview)
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
                                expense_category_id: '',
                                amount: '',
                                entry_date: ''
                            };
                            $this.dt.draw();
                        });
                }
            },
            mounted() {
                var $this = this;
                var myModal = new bootstrap.Modal(document.getElementById('expenseUpdateModal'), {
                    keyboard: false
                });

                $this.dt = $('#expense-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('expense.table') }}',
                        type: 'POST'
                    },
                    order: [2, 'desc'],
                    columns: [{
                            data: 'category_name',
                            title: 'Expense Category'
                        },
                        {
                            data: 'amount',
                            title: 'Amount'
                        },
                        {
                            data: 'entry_date',
                            title: 'Entry Date'
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
