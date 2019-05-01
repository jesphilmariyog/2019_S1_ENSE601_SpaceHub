const clocks = document.getElementsByClassName('clock');

//updateTime is a function that uses moment.js library to handle time and dates easily
function updateTime() {
    console.log('Im working!');
    for (let clock of clocks) {

        // var now;
        // if (typeof clock.id == "string") {
        const now = moment(new Date()).tz(clock.id);
        // } else {
        //     now = moment(); //generates the current date and time
        // }
        const humanReadable = now.format('HH:mm:ss'); //display in hours:minutes:seconds
        clock.textContent = humanReadable; //the text content of the HTML is set to whatever humanReadable holds
    }
}

setInterval(updateTime, 1000); //setInterval is a function that calls a function every x seconds
updateTime();