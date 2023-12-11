// Function to calculate age based on a constant DOB
function calculateMyAge() {
    // Set your constant date of birth
    var myDOB = new Date("2003-11-15"); // Replace "Your-DOB-Here" with your actual DOB

    // Get the current date
    var today = new Date();

    // Calculate the age
    var age = today.getFullYear() - myDOB.getFullYear();

    // Adjust age if birthday hasn't occurred yet this year
    if (today.getMonth() < myDOB.getMonth() || 
        (today.getMonth() === myDOB.getMonth() && today.getDate() < myDOB.getDate())) {
        age--;
    }

    // Display the result
    var myAgeResultContainer = document.getElementById("myAgeResult");
    myAgeResultContainer.innerHTML = age;
}
window.addEventListener('load', calculateMyAge);