@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Create Questions</div>

                <div class="card-body">

                    <question-component
                        api_token="{!! Auth::user()->api_token !!}"
                        v-on:add="addNewQuestion"
                        v-bind:_question="question"
                    />

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Questions Dashboard</div>

                <div class="card-body">
                   
                    <questions-component
                        api_token="{!! Auth::user()->api_token !!}"
                        v-bind:questions="questions"
                        v-on:update="getQuestions"
                        v-on:delete="getQuestions"
                    />

                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    api_token: "{!! Auth::user()->api_token !!}",
                    questions: [],
                    question: {},
                }
            },
            mounted() {
                this.getQuestions();
            },
            methods: {
                getQuestions() {
                    axios.get(`/api/question?api_token=${this.api_token}`)
                        .then((response) => {
                            this.questions = response.data.data;
                        })
                        .catch(function (error) {
                            console.log(error.response);
                        })
                },
                addNewQuestion() {
                    this.getQuestions();
                },
            },
        });
    </script>
@endsection
