<template>
    <div>
        <form action="" class="form-inline">
            <div class="form-group">
                <label for="">Search</label>
                <input type="text" class="form-control mx-sm-3" v-model="searchQuery">
                <button class="btn btn-primary" v-on:click.stop.prevent="btnSearch">Search</button>
            </div>
        </form>
        <table class="table table-bordered table-hover mt-2">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(visitor, index) in visitors.data" :key="index" v-on:click="rowClicked(visitor)">
                    <td>{{ visitor.name }}</td>
                    <td>{{ visitor.age }}</td>
                    <td>{{ visitor.purpose }}</td>
                    <td>{{ visitor.status }}</td>
                </tr>
            </tbody>
        </table>

        <pagination :data="visitors" @pagination-change-page="getVisitors"></pagination>

        <!-- Modal -->
        <div class="modal fade" id="visitorModal" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visitorModalLabel">Visitor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="isLoading" class="text-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div v-else>
                    <h3>{{ visitor.name }}</h3>
                    <span><strong>temp</strong> {{ visitor.temp }}</span><br>
                    <span><strong>gender</strong> {{ visitor.gender }}</span><br>
                    <span><strong>age</strong> {{ visitor.age }}</span><br>
                    <span><strong>phone</strong> {{ visitor.phone }}</span><br>
                    <span><strong>address</strong> {{ visitor.address }}</span><br>
                    <span><strong>purpose</strong> {{ visitor.purpose }}</span><br>
                    <span v-if="visitor.purpose == 'Official'"><strong>Company Name</strong> {{ visitor.company_name }}<br></span>
                    <span v-if="visitor.purpose == 'Official'"><strong>Company Address</strong> {{ visitor.company_address }}<br></span>
                    <hr>
                    <strong><em>Checklist</em></strong><br><br>

                    <p v-for="(answer, index) in checkList.answers" :key="index" class="text-justify">
                        <strong>{{ index+1 }}.</strong> {{ answer.question.question }}<br><strong>{{ answer.answer }}</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-success" @click="approve(true)">APPROVE</button>
                <button type="button" class="btn btn-danger" @click="approve(false)">DECLINE</button>
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['api_token'],
        data() {
            return {
                visitor: {
                    id: 0,
                    name: '',
                    temp: '',
                    gender: '',
                    age: '',
                    phone: '',
                    address: '',
                    purpose: '',
                    company_name: '',
                    company_address: '',
                    approved_at: '',
                    rejected_at: '',
                },
                visitors: {},
                checkList: [],
                isLoading: true,
                searchQuery : '',
            }
        },
        mounted() {
            this.getVisitors();

            Echo
            .channel('new-visitor')
            .listen('NewVisitor', (payload) => {
                this.getVisitors();
            });
        },

        methods: {
            rowClicked(data) {
                this.isLoading = true;
                $('#visitorModal').modal('show');

                this.visitor.id = data.id;
                this.visitor.name = data.name;
                this.visitor.temp = data.temp;
                this.visitor.gender = data.gender;
                this.visitor.age = data.age;
                this.visitor.phone = data.phone;
                this.visitor.address = data.address;
                this.visitor.purpose = data.purpose;
                this.visitor.company_name = data.company_name;
                this.visitor.company_address = data.company_address;
                this.approved_at = data.approved_at;
                this.rejected_at = data.rejected_at;

                axios
                .get(`/api/visitors/checklist/${data.id}?api_token=${this.api_token}`)
                .then((response) => {
                    this.isLoading = false;
                    this.checkList = response.data.data;
                    console.log(response.data);
                })
                .catch(function(error) {
                    toastr.error(error.message, 'Error');
                });
            },

            approve(bool) {
                axios
                .post(`/api/visitor/approval/${this.visitor.id}?api_token=${this.api_token}`, {id: this.visitor.id, approve: bool})
                .then((response) => {
                    $('#visitorModal').modal('toggle');
                    this.getVisitors();
                })
                .catch(function(error) {
                    console.log('Approval Error', error.message);
                })
            },

            btnSearch() {
                this.getVisitors()
            },

            getVisitors(page = 1) {
                axios
                .get(`/api/visitors/get?api_token=${this.api_token}&page=${page}&query=`+encodeURI(this.searchQuery))
                .then((response) => {
                    this.visitors = response.data;
                })
                .catch(function(error) {
                    console.log(error.message);
                });
            }
        },
    }
</script>

<style scoped>
    tbody tr {
        cursor: pointer;
    }
</style>
