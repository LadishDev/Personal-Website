export function calculateAge(birthDate) {
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();

  if (
    today.getMonth() < birthDate.getMonth() ||
    (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())
  ) {
    age--;
  }

  return age;
}

export function updateAge(spanId, birthDateString) {
  const ageSpan = document.getElementById(spanId);
  if (!ageSpan) return;
  const birthDate = new Date(birthDateString);
  ageSpan.textContent = calculateAge(birthDate);
}
