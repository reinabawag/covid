@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div v-if="!waitingForApproval" class="col-md-12">
            <h3><strong>Visitors shall accomplish the checklist</strong></h3>
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
                    <input type="number" class="form-control" id="temp" step="0.1" v-model="info.temp" placeholder="Temperature" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="" class="form-control" v-model="info.gender" id="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" v-model="info.age" placeholder="Age" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" class="form-control" id="phone" v-model="info.phone" placeholder="Phone number" required>
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
                        <label for="q-{{ $question->id }}" style="text-align: justify">{{ $index + 1 }}. {{ $question->question }}</label>
                        <select name="{{ $question->id }}" id="q-{{ $question->id }}" v-model="info.ans[{{ $question->id }}]" class="form-control" required>
                            <option value="Yes">Yes</option>
                            <option value="No" selected>No</option>
                        </select>
                        @if ($question->is_additional)
                            <input v-if="info.ans[{{ $question->id }}] == 'Yes'" v-model="info.additional[{{ $question->id }}]" type="text" class="form-control mt-2 mb-2" placeholder="If yes, provide your answer here" required>
                        @endif
                    </div>
                @endforeach

                <hr>
                <div class="form-check">
                    <input class="form-check-input" v-model="isAccepted" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1" style="text-align: justify">
                        I hereby authorize <em><b>American Wire & Cable Co., Inc.</b></em> to collect and process the data indicated herein for the purpose of contact tracing effecting control of the COVID-19 transmission.
                        I understand that my personal information is protected by RA 10173 or the Data Privacy Act of 2012 and this form will be destroyed after 30 days from the date of accomplishment, following the National Archives of the Philippine protocol.
                    </label>
                </div>
                <hr>

                <button class="btn btn-success btn-block" :disabled="!isAccepted" type="submit">Submit</button>
            </form>
        </div>
        <div v-else class="col-md-12">
            <div class="text-center">
                <div v-if="loader" class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <br>
                <br>
                <h4>@{{ message }}</h4>
            </div>
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
                    gender: 'Male',
                    purpose: 'Official',
                },
                selected: 'Official',
                isOfficial: true,
                waitingForApproval: false,
                message: 'Waiting for approval',
                loader: true,
                isAccepted : false,
            },
            methods: {
                formSubmit() {

                    this.waitingForApproval = true;

                    axios
                    .post(`/api/visitor`, this.info)
                    .then((response) => {
                        this.info = {};
                        this.info.ans = [],
                        this.info.additional = [];
                        toastr.success(response.data.message, 'Checklist submitted!');
                        console.log('Response from  submit', response.data);

                        Echo
                        .channel(`visitor.${response.data.visitor.id}`)
                        .listen('ForApproval', (payload) => {
                            this.loader = false;
                            if (payload.status) {
                                // toastr.success('Approved');
                                this.message = 'Visit approved';
                            } else {
                                // toastr.warning('Rejected');
                                this.message = 'Visit rejected!';
                            }
                            console.log('For approval payload', payload);
                        });

                    })
                    .catch(function(error) {
                        toastr.error(error.message, 'Error');
                    })
                }
            },
        });
    </script>
@endsection
