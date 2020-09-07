@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><strong>All visitors shall accomplish the visitors checklist</strong></h3>
            <h5><strong>Health Checklist</strong></h5>
            <hr>
            <strong>Personal Information:</strong>
            <form>
                <div class="form-group">
                    <label for="name" class="mt-2">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Last name, Firstname Middle name">
                </div>
                <div class="form-group">
                    <label for="temp">Temp</label>
                    <input type="text" class="form-control" id="temp" placeholder="Temperature">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <input type="text" class="form-control" id="gender" placeholder="Gender">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" class="form-control" id="age" placeholder="Age">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Address">
                </div>
                <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <select name="purpose" id="purpose" class="form-control" v-model="selected">
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                    </select>
                </div>
                <div class="form-group" v-if="isOfficial">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" placeholder="Company Name">
                </div>
                <div class="form-group" v-if="isOfficial">
                    <label for="company_address">Company Address</label>
                    <input type="text" class="form-control" id="company_address" placeholder="Company Address">
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
                        <select name="{{ $index }}" id="{{ $index }}" class="form-control">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                   
                @endforeach
            </form>
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
                    selected: 'Official',
                    isOfficial: true,
                }
            },
            methods: {
                
            },
            watch: {
                selected() {
                    if (this.selected == 'Official') 
                        this.isOfficial = true
                    else
                        this.isOfficial = false
                }
            }
        });
    </script>
@endsection
