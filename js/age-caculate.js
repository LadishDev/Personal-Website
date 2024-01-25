function calculateMyAge() {
    // Uses the dob to calculate the age based on the current date
    var myDOB = new Date("2003-11-15");
    var today = new Date();
    var age = today.getFullYear() - myDOB.getFullYear();

    // If the birthday has not passed yet, subtract one
    if (today.getMonth() < myDOB.getMonth() || 
        (today.getMonth() === myDOB.getMonth() && today.getDate() < myDOB.getDate())) {
        age--;
    }

    // Display the age
    var myAgeResultContainer = document.getElementById("myAgeResult");
    myAgeResultContainer.innerHTML = age;
}
window.addEventListener('load', calculateMyAge);