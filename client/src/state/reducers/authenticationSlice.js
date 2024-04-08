import {createSlice} from "@reduxjs/toolkit";
import {ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "../../config/constants";

export const authenticationSlice = createSlice({
    name: 'authentication',
    initialState: {
        loggedIn: false,
        role: 'guest',
        token: '',
        userId: '',
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
        },
        setToken: (state, action) => {
            state.token = action.payload;
        },
        setUserId: (state, action) => {
            state.userId = action.payload;
        },
    }
});

export const {
    setLoggedInTrue,
    setLoggedInFalse,
    setPatientRole,
    setDoctorRole,
    setAdminRole,
    setGuestRole,
    setToken,
    setUserId,
} = authenticationSlice.actions;

export default authenticationSlice.reducer;
