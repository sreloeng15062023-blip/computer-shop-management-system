var myModal = document.getElementById('exampleModal');

myModal.addEventListener('show.bs.modal', function(event) {
var button = event.relatedTarget; // Button clicked
var studentId = button.getAttribute('data-id');

// Fetch student details
fetch("getStudent.php?id=" + studentId)
        .then(res => res.json())
        .then(data => {
        function capitalize(str) { 
            if (!str) return ""; 
            str = str.trim(); 
            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase(); 
        }

        // Fill modal with data
        document.getElementById('studentPhoto').src = data.photo_url;
        document.getElementById('studentName').textContent = data.last_name + " " + data.first_name;
        document.getElementById('studentGender').textContent = capitalize(data.gender);
        document.getElementById('studentDob').textContent = data.date_of_birth;
        document.getElementById('studentAddress').textContent = data.address;
        document.getElementById('studentCreated').textContent = data.created_at;
    });
});