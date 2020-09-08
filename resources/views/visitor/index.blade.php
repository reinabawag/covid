@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><strong>All visitors shall accomplish the visitors checklist</strong></h3>
            <h5><strong>Health Checklist</strong></h5>
            <hr>
            <strong>Personal Information:</strong>
            <form @submit.prevent="formSubmit">
                <div class="form-group">
                    <label for="name" class="mt-2">Name</label>
                    <input type="text" class="form-control" id="name" v-model="info.name" placeholder="Last name, Firstname Middle name" required>
                </div>
                <div class="form-group">
                    <label for="temp">Temp</label>
                    <input type="text" class="form-control" id="temp" v-model="info.temp" placeholder="Temperature" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <input type="text" class="form-control" id="gender" v-model="info.gender" placeholder="Gender" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" class="form-control" id="age" v-model="info.age" placeholder="Age" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" v-model="info.address" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <select name="purpose" id="purpose" class="form-control" v-model="info.purpose">
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                    </select>
                </div>
                <div class="form-group" v-if="info.purpose == 'Official'">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" v-model="info.company_name" placeholder="Company Name">
                </div>
                <div class="form-group" v-if="info.purpose == 'Official'">
                    <label for="company_address">Company Address</label>
                    <input type="text" class="form-control" id="company_address" v-model="info.company_address" placeholder="Company Address">
                </div>

                <hr>

                <strong>Health and Travel Declaration:</strong>

                <br><br>

                @foreach ($questions as $index => $question)
                    @if ($question->title)
                        <strong><em>{{ $question->title }}</em></strong><br>
                    @endif
                    <div class="form-group">
                        <label for="{{ $index }}">{{ $index + 1 }}. {{ $question->question }}</label>
                        <select name="{{ $question->id }}" id="{{ $question->id }}" v-model="info.ans[{{ $question->id }}]" class="form-control" required>
                            <option value="Yes">Yes</option>
                            <option value="No" selected>No</option>
                        </select>
                        @if ($question->is_additional)
                            <input v-if="info.ans[{{ $question->id }}] == 'Yes'" v-model="info.additional[{{ $question->id }}]" type="text" class="form-control mt-2 mb-2" placeholder="If yes, provide your answer here" required>
                        @endif
                    </div>
                @endforeach
                <button class="btn btn-success btn-block" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {      
                info: {
                    ans: [0],
                    additional: [0],
                    purpose: 'Official',
                },      
                selected: 'Official',
                isOfficial: true,
            },
            methods: {
                formSubmit() {
                    axios
                    .post(`/api/visitor`, this.info)
                    .then((response) => {
                        this.info.ans = [],
                        this.info.additional = [];
                        console.log(response.data);
                    })
                    .catch(function(error) {
                        console.log(error.message);
                    })
                }
            },
        });
    </script>
@endsection
