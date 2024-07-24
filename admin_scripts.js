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

            for (let patient of patients) {
                let row = document.createElement('tr');
        
                let name_cell = document.createElement('td');
                name_cell.innerHTML = patient['patient_name'];
        
                let severity_cell = document.createElement('td');
                severity_cell.innerHTML = patient['severity_level'];
        
                let arrival_cell = document.createElement('td');
                arrival_cell.innerHTML = patient['time_of_arrival'];
        
                let code_cell = document.createElement('td');
                code_cell.innerHTML = patient['code'];
        
                let timer_cell = document.createElement('td');
        
                timeOfArrival = new Date(patient['time_of_arrival']);
        
                let currentTime = new Date();
                let timeDifferenceInSeconds = Math.floor((Math.abs(currentTime - timeOfArrival)) / 1000);
        
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
        
                    timer_cell.innerHTML = hour + ":" + minute + ":" + seconds;
                }
                
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

async function addPatient(event) {
    event.preventDefault(); // Prevent the form from submitting normally
            
    // Get the form input values
    var patient_name = document.getElementById('patient_name').value;
    var severity_level = document.getElementById('severity_level').value;
    
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        console.log(this.readyState);
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText); 
            getPatients();
        }
    }
    let time_of_arrival = new Date().toISOString();
    console.log(time_of_arrival);

    var req = new XMLHttpRequest();
    const url = `admin_logic.php?action=addPatient&patient_name=${patient_name}&severity_level=${severity_level}&time_of_arrival=${time_of_arrival}`;
    req.open("GET", url, true);
    console.log(url);
    req.send();
}

async function removePatient(patient_id) {

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText); 
            getPatients();
        }
    }

    req.open("DELETE", "admin_logic.php?action=removePatient&patient_id=" + patient_id, true);
    req.send();

    
}

