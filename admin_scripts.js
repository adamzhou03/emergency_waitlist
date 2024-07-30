window.onload = function() {
    getPatients();
    document.getElementById('patientForm').addEventListener('submit', addPatient);
}

async function getPatients() {
    var req = new XMLHttpRequest();
    let patient_table = document.getElementById('patient_table');
    patient_table.innerHTML = "";

    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) { 
            var patients = JSON.parse(this.responseText);
            let head = document.createElement('tr');
            let name_head = document.createElement('td');
            let severity_head = document.createElement('td');
            let arrival_head = document.createElement('td');
            let code_head = document.createElement('td');
            let timer_head = document.createElement('td');
            let remove_head = document.createElement('td');

            name_head.innerHTML = "Name";
            severity_head.innerHTML = "Severity";
            arrival_head.innerHTML = "Arrival Time";
            code_head.innerHTML = "Patient Code";
            timer_head.innerHTML = "Time in Queue";
            remove_head.innerHTML = "";

            head.appendChild(name_head);
            head.appendChild(severity_head);
            head.appendChild(arrival_head);
            head.appendChild(code_head);
            head.appendChild(timer_head);
            head.appendChild(remove_head);

            patient_table.appendChild(head);

            for (let patient of patients) {
                let row = document.createElement('tr');
        
                let name_cell = document.createElement('td');
                name_cell.innerHTML = patient['patient_name'];
        
                let severity_cell = document.createElement('td');
                severity_cell.innerHTML = patient['severity_level'];
        
                let code_cell = document.createElement('td');
                code_cell.innerHTML = patient['code'];
        
                let timer_cell = document.createElement('td');
        
                timeOfArrival = new Date(patient['time_of_arrival']);
        
                let currentTime = new Date();

                let offset = currentTime.getTimezoneOffset()/60;

                timeOfArrival.setHours(timeOfArrival.getHours() - offset);

                let arrival_cell = document.createElement('td');
                arrival_cell.innerHTML = timeOfArrival;

                let timeDifferenceInSeconds = Math.floor((Math.abs(currentTime - timeOfArrival)) / 1000);

                function createTimer(cell) {
                    setInterval(countTimer, 1000);
        
                    var totalSeconds = timeDifferenceInSeconds;
                    function countTimer() {
                        ++totalSeconds;
                        
                        var hour = Math.floor(totalSeconds / 3600);
                        var minute = Math.floor((totalSeconds - hour * 3600) / 60);
                        var seconds = totalSeconds - (hour * 3600 + minute * 60);
                        if (hour < 10)
                            hour = "0" + hour;
                        if (minute < 10)
                            minute = "0" + minute;
                        if (seconds < 10)
                            seconds = "0" + seconds;
            
                        cell.innerHTML = hour + ":" + minute + ":" + seconds;
                    }
                }

                createTimer(timer_cell);
                
                
                let remove_cell = document.createElement('td');
                row.appendChild(remove_cell);
                let remove_button = document.createElement('button');
                remove_button.textContent = 'Remove';
                remove_button.patient_id = patient['patient_id'];
                remove_cell.appendChild(remove_button);
                remove_button.addEventListener("click", function() {
                    removeClickHandler(remove_button.patient_id);
                })

                row.appendChild(name_cell);
                row.appendChild(severity_cell);
                row.appendChild(arrival_cell);
                row.appendChild(code_cell);
                row.appendChild(timer_cell);
                row.appendChild(remove_cell);
                
                patient_table.appendChild(row);
            }
        }
    }

    req.open("GET", "admin_logic.php?action=" + 'getPatients', true);
    req.send();

    

    
}

async function removeClickHandler(id) {
    removePatient(id);
}

function addPatient(event) {
    event.preventDefault(); // Prevent the form from submitting normally
            
    // Get the form input values
    var patient_name = document.getElementById('patient_name').value;
    var severity_level = document.getElementById('severity_level').value;
    
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        getPatients();
        if (this.readyState == 4 && this.status == 200) {
            
        }
    }
    let time_of_arrival = new Date().toISOString();

    console.log(new Date());

    console.log(time_of_arrival);

    var req = new XMLHttpRequest();
    const url = `admin_logic.php?action=addPatient&patient_name=${patient_name}&severity_level=${severity_level}&time_of_arrival=${time_of_arrival}`;
    req.open("POST", url, true);
    req.send();
    getPatients();
}

async function removePatient(patient_id) {

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        
        if (this.readyState == 4 && this.status == 200) {
            getPatients();
        }
    }

    req.open("DELETE", "admin_logic.php?action=removePatient&patient_id=" + patient_id, true);
    req.send();

    
}

