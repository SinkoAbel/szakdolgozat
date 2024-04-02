import {createSlice} from "@reduxjs/toolkit";
import {ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "../../config/constants";

export const authenticationSlice = createSlice({
    name: 'authentication',
    initialState: {
        loggedIn: false,
        role: 'guest',
    },
    reducers: {
        setLoggedInTrue: (state) => {
            state.loggedIn = true;
        },
        setLoggedInFalse: (state) => {
            state.loggedIn = false;
        },
        setPatientRole: (state) => {
            state.role = ROLE_PATIENT;
        },
        setDoctorRole: (state) => {
            state.role = ROLE_DOCTOR;
        },
        setAdminRole: (state) => {
            state.role = ROLE_ADMIN;
        },
        setGuestRole: (state) => {
            state.role = 'guest';
        }
    }
});

export const {
    setLoggedInTrue,
    setLoggedInFalse,
    setPatientRole,
    setDoctorRole,
    setAdminRole,
    setGuestRole,
} = authenticationSlice.actions;

export default authenticationSlice.reducer;
