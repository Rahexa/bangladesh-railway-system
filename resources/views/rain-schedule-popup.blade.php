<!-- resources/views/train-schedule-popup.blade.php -->
<div class="popup" id="trainSchedulePopup" style="display: none;">
    <span class="close" id="closeTrainSchedulePopup">&times;</span>
    <h2 id="routeHeader">Train Schedule: From - To</h2>
    <div id="trainScheduleList"></div>
</div>

<style>
    /* Popup Styles */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        width: 90%;
        max-width: 600px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid #151B4F;
    }

    /* Popup Header */
    .popup h2 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #151B4F;
        font-weight: 600;
    }

    /* Close Button */
    .close {
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: #aaa;
    }

    .close:hover {
        color: #000;
    }

    /* Train Schedule List */
    .train-schedule-item {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: left;
    }

    .book-now {
        background-color: #151B4F;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .book-now:hover {
        background-color: #0e1a3d;
    }
</style>

<script>
    $(document).ready(function () {
        // Function to show train schedule popup
        function showTrainSchedule(fromStation, toStation) {
            $('#routeHeader').text(`Train Schedule: ${fromStation} to ${toStation}`);
            
            // Fetch train schedules from the server
            $.ajax({
                url: '/get-train-schedules', // Your endpoint to fetch train schedules
                method: 'GET',
                data: { from: fromStation, to: toStation },
                success: function (data) {
                    $('#trainScheduleList').empty(); // Clear previous results
                    data.forEach(function (train) {
                        const availableSeats = `AC_B: ${train.AC_B}, AC_S: ${train.AC_S}, SNIGDHA: ${train.SNIGDHA}`;
                        $('#trainScheduleList').append(`
                            <div class="train-schedule-item">
                                <strong>${train.train_name}</strong><br>
                                Type: ${train.train_type}<br>
                                Arrival: ${train.arrival_time}<br>
                                Departure: ${train.departure_time}<br>
                                Available Seats: ${availableSeats}<br>
                                <button class="book-now" data-train-id="${train.id}">Book Now</button>
                            </div>
                        `);
                    });
                    $('#trainSchedulePopup').fadeIn(); // Show the popup
                },
                error: function () {
                    alert('Error fetching train schedules.');
                }
            });
        }

        // Close the Train Schedule Popup
        $('#closeTrainSchedulePopup').on('click', function () {
            $('#trainSchedulePopup').fadeOut();
        });

        // Example of how to trigger the popup (replace with your actual trigger)
        $('#someButton').on('click', function () {
            showTrainSchedule('Dhaka', 'Chittagong'); // Replace with selected stations
        });
    });
</script>