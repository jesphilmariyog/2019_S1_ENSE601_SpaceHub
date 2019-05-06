const clocks = document.getElementsByClassName('clock');

// updateTime is a function that uses moment.js library to handle time and dates easily
function updateTime() {
    for (let clock of clocks) {
        clock.textContent = clock.id + "\n" + moment(new Date()).tz(clock.id).format("HH:mm");
    }
}

// setInterval is a function that calls a function every x seconds
setInterval(updateTime, 60000);
updateTime(); // need to update immediately at first.