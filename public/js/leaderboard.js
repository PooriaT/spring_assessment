document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/leaderboard/participants')
        .then(response => response.json())
        .then(participants => {
            participants.forEach(participant => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><button class="delete-btn" data-participant-id="${participant.id}">X</button></td>
                    <td><a href="#" class="participant-link" data-participant-id="${participant.id}">${participant.name}</a></td>
                    <td><button class="add-btn" data-participant-id="${participant.id}">+</button></td>
                    <td><button class="sub-btn" data-participant-id="${participant.id}">-</button></td>
                    <td>${participant.points} point(s)</td>
                `;
                document.getElementById('participant-list').appendChild(row);
            });

            // Add event listeners for buttons and actions
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const participantId = this.getAttribute('data-participant-id');
                    deleteParticipant(participantId);
                });
            });

            document.querySelectorAll('.participant-link').forEach(link => {
                link.addEventListener('click', function () {
                    const participantId = this.getAttribute('data-participant-id');
                    showParticipantDetails(participantId);
                });
            });

            document.querySelectorAll('.add-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const participantId = this.getAttribute('data-participant-id');
                    updatePoints(participantId, 'add');
                });
            });

            document.querySelectorAll('.sub-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const participantId = this.getAttribute('data-participant-id');
                    updatePoints(participantId, 'sub');
                });
            });

            document.getElementById('add-participant').addEventListener('click', function () {
                addParticipantForm();
            });

            document.getElementById('show-winner').addEventListener('click', function () {
                showWinner();
            })
        });
});

async function deleteParticipant(participantId) {
    console.log(`Deleting participant with ID: ${participantId}`);
    const requestOptions = {
        method: 'DELETE',
    };
    try {
        const response = await fetch(`/api/leaderboard/deleteparticipant/${participantId}`, requestOptions);
        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }
        console.log('Points updated successfully');
    } catch (error) {
        console.error('Error updating participant points:', error);
    }
}

async function showParticipantDetails(participantId) {
    try {
        console.log(`Fetching details for participant with ID: ${participantId}`);
        const response = await fetch(`/api/leaderboard/participants/${participantId}`);
        const participant = await response.json();
        const detailsElement = document.getElementById('participant-details');
        detailsElement.innerHTML = `
            <h2>Participant Details</h2>
            <p><strong>Name:</strong> ${participant.name}</p>
            <p><strong>Age:</strong> ${participant.age}</p>
            <p><strong>Points:</strong> ${participant.points}</p>
            <p><strong>Address:</strong> ${participant.address}</p>
            <p><strong>QR Code Image:</strong></p>
            <img src="storage/qrImages/${participant.qr_code_filename}" alt="QR Code Image">
        `;
        } catch (error) {
        console.error('Error fetching participant details:', error);
        // Handle errors, e.g., show an error message
    }
}

async function updatePoints(participantId, action) {
    console.log(`Updating points for participant with ID ${participantId}: ${action}`);
    const requestOptions = {
        method: 'PUT',
    };
    try {
        const response = await fetch(`/api/leaderboard/participants/point/${action}/${participantId}`, requestOptions);
        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }
        console.log('Points updated successfully');
    } catch (error) {
        console.error('Error updating participant points:', error);
    }
}

function addParticipantForm() {
    console.log('Showing the add participant form');
    const form = document.getElementById('add-participant-form');
    form.innerHTML = `
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age">
        <br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
        <button type="submit" id="add-participant-btn">Add Participant</button>
    `;

    const addParticipantBtn = document.getElementById('add-participant-btn');
    addParticipantBtn.addEventListener('click', async (event) => {
        event.preventDefault(); // Prevent the default form submit action
        await addParticipant();
    });
}

async function addParticipant() {
    console.log('Adding a new participant');
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const address = document.getElementById('address').value;

    try {
        const response = await fetch('/api/leaderboard/addparticipant', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, age, address }),
        });
        const result = await response.json();
        document.getElementById('add-participant-alert').innerHTML = JSON.stringify(result, undefined, 2);
    } catch (error) {
        console.error('Error adding new participant:', error);
    }
}

async function showWinner() {
    console.log('Showing the winner');
    try{
        const response = await fetch('/api/leaderboard/winner');
        const result = await response.json();
        document.getElementById('winner-details').innerHTML = JSON.stringify(result, undefined, 2);
    } catch (error) {
        console.error('Error showing the winner:', error);
    }
}