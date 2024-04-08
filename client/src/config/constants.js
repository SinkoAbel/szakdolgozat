export const ROLE_PATIENT = "patient";
export const ROLE_DOCTOR = "doctor";
export const ROLE_ADMIN = "admin";

export const getRoleAlias = (role) => {
    switch (role) {
        case ROLE_PATIENT:
            return 'Páciens';
        case ROLE_DOCTOR:
            return 'Orvos';
        case ROLE_ADMIN:
            return 'Admin';
        default:
            console.error('No valid role name found');
            return;
    }
}
