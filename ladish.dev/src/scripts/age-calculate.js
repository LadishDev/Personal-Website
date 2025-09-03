// Encode the birth date to make it slightly harder to read
const encodedDate = "MjAwMy0xMS0xNQ=="; // Base64 encoded "2003-11-15"

export function updateAge(elementId) {
    try {
        // Decode the date at runtime
        const birthDate = new Date(atob(encodedDate));
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = age;
        }
    } catch (e) {
        console.error('Age calculation failed:', e);
        const element = document.getElementById(elementId);
        if (element) element.textContent = '-';
    }
}