@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label for="exampleInputEmail1">School</label>
                <select class="form-control" id="schoolSelect" name="school_id">
                    <option value="">All Schools</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Country</label>
                <select class="form-control" id="countrySelect" name="country">
                    <option value="">All Countries</option>
                    @foreach($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>
    <button id="searchButton" class="btn btn-primary float-end mt-3">Search</button>



    <div id="searchResults" class="row mt-5" >

    </div>


    <div style="width: 100%; margin: auto;" class="mt-5">
        <h5>Schools and No. of Members - Bar Chart</h5>
        <canvas id="schoolChart"></canvas>
    </div>


    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/chart/',
                type: 'GET',
                success: function(response) {
                    var schoolData = response.schools;

                    var schoolNames = schoolData.map(item => item.name);
                    var memberCounts = schoolData.map(item => item.memberCount);

                    var ctx = document.getElementById('schoolChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {

                            labels: schoolNames,
                            datasets: [{
                                label: 'Number of Members',
                                data: memberCounts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        // forces step size to be 50 units
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });

            // Function to display search results
            function displayResults(schools) {
                var resultsHtml = '';
                resultsHtml += '<ul>';

                schools.forEach(function(school) {
                    resultsHtml += '<li>';
                    resultsHtml += '<strong>' + school.name + '</strong> - Members:';
                    resultsHtml += '<ul>';

                    school.members.forEach(function(member) {
                        resultsHtml += '<li>' + member.name + ' - ' + member.email + '</li>';
                    });

                    resultsHtml += '</ul>';
                    resultsHtml += '</li>';
                });

                resultsHtml += '</ul>';
                $('#searchResults').html(resultsHtml);
            }



            $('#searchButton').click(function() {
                console.log('clicked');
                var selectedSchool = $("#schoolSelect").val();
                var selectedCountry = $("#countrySelect").val();


                // Send an AJAX request to fetch schools and members for the selected country
                $.ajax({
                    url: '/search',
                    type: 'GET',
                    data: { school: selectedSchool, country: selectedCountry },
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        // Call the displayResults function to render the data
                        console.log(response.schools);
                        displayResults(response.schools);
                    },
                    error: function(error) {
                        console.error(error);
                        $('#searchResults').html('<p>Error fetching results.</p>');
                    }
                });
            });
        });
    </script>
@endsection
