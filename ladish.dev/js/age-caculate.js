function calculateMyAge() {
    var myDOB = new Date("2003-11-15");
    var today = new Date();
    var age = today.getFullYear() - myDOB.getFullYear();

    if (today.getMonth() < myDOB.getMonth() || 
        (today.getMonth() === myDOB.getMonth() && today.getDate() < myDOB.getDate())) {
        age--;
    }

    var myAgeResultContainer = document.getElementById("myAgeResult");
    myAgeResultContainer.innerHTML = age;
}
window.addEventListener('load', calculateMyAge);