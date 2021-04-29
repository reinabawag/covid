<template>
  <div>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Title</th>
            <th scope="col">Question</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(question, index) in questions" v-bind:key="index" @click="rowClicked(question)">
                <td v-text="question.title"></td>
                <td v-text="question.question"></td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade" data-backdrop="static" tabindex="-1" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="question.title"  id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea class="form-control" v-model="question.question" v-bind:class="{ 'is-invalid': errors.question }" id="question" placeholder="Question" cols="30" rows="10"></textarea>
                            <div v-if="errors.question" class="invalid-feedback">
                                <span v-for="q in errors.question" :key="q" v-text="q" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question">Is additional</label>
                            <select id="question" class="form-control" v-model="question.is_additional">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" @click="deleteQuestion">Delete</button>
                    <button type="button" class="btn btn-primary" @click="updateQuestion">Save changes</button>
                </div>
            </div>
        </div>
    </div>

  </div>
</template>

<script>
export default {
    props: {
        api_token: {
            type: String,
            required: true,
        },
        questions: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            question: {
                id: 0,
                title: '',
                question: '',
                is_additional: 0,
            },
            errors: {},
            message: '',
        }
    },
    watch: {
        
    },
    methods: {
        updateQuestion() {
            axios
            .post(`/api/question/update/${this.question.id}?api_token=${this.api_token}`, this.question)
            .then((response) => {
                if (response.status == 200) {
                    this.$emit('update');
                    $('#myModal').modal('toggle');
                    toastr.success(response.data.data.message, 'Success');
                }
            })
            .catch((error) => {
                this.errors = error.response.data.errors;
                toastr.error(error.response.data.message, 'Error');
            })          
        },
        deleteQuestion() {
            axios
            .delete(`/api/question/${this.question.id}?api_token=${this.api_token}`, this.question)
            .then((response) => {
                this.$emit('delete');
                toastr.success(response.data.message, 'Success');
                $('#myModal').modal('toggle');
            })
            .catch(function(error) {
                toastr.error(error.message, 'Error');
            })
        },
        rowClicked(data) {
            this.question.id = data.id;
            this.question.title = data.title;
            this.question.question = data.question;
            this.question.is_additional = data.is_additional;
            this.errors = {};
            $('#myModal').modal('toggle');
        }
    }
}
</script>

<style scoped>
    tbody tr {
        cursor: pointer;
    }
    tbody tr:hover {
        background-color: #e9ecef;
    }
    ul {
        list-style-type: none;
    }
</style>