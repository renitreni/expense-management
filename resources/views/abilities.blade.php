@extends('layouts.app')

@section('title')
    Abilities
@endsection


@section('content')
    <div class="row g-4 settings-section">
        <div id="app" class="row">
            <div class="col-auto">
                <h3 class="section-title">{{ $name }}</h3>
                <div class="section-intro">Please select abilities for this role.</div>
            </div>
            <div class="col-12 col-md-auto">
                <div class="card shadow-sm p-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="accounts" v-model="roles">
                                    <label class="form-check-label">Accounts</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="roles" v-model="roles">
                                    <label class="form-check-label">Roles</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense" v-model="roles">
                                    <label class="form-check-label">Expense</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-create" v-model="roles">
                                    <label class="form-check-label">Expense Create</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-update" v-model="roles">
                                    <label class="form-check-label">Expense Update</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-delete" v-model="roles">
                                    <label class="form-check-label">Expense Delete</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-cat" v-model="roles">
                                    <label class="form-check-label">Expense Category</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-cat-create" v-model="roles">
                                    <label class="form-check-label">Expense Category Create</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-cat-update" v-model="roles">
                                    <label class="form-check-label">Expense Category Update</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" value="expense-cat-delete" v-model="roles">
                                    <label class="form-check-label">Expense Category Delete</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button @click="saveAbilities" type="button" class="btn btn-primary">Save
                                Changes</button>
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
            </div>
            <!--//row-->
        </div>
    @endsection


    @section('scripts')
        <script>
            const e = new Vue({
                el: '#app',
                data: {
                    roles: {!! $abilities !!}
                },
                methods: {
                    saveAbilities() {
                        axios.post('{{ route('abilities.save') }}', {
                            name: '{{ $name }}',
                            roles: this.roles
                        }).then(function(value) {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        });
                    }
                }
            });

        </script>
    @endsection
