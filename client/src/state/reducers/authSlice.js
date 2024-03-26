import {createSlice} from "@reduxjs/toolkit";

export const authSlice = createSlice({
    name: 'auth',
    initialState: {
        userID: null,
        token: null,
        authenticated: false,
        userType: null,
    },
    reducers: {
        setUserID: (state, action) => {
            state.patientID = action.payload;
        },
        setToken: (state, action) => {
            state.token = action.payload;
        },
        setAuthenticated: (state, action) => {
            state.patientAuthenticated = action.payload;
        },
        setUserType: (state, action) => {
            state.userType = action.payload;
        },
        clearAuth: (state, action) => {
            state.userID = null;
            state.token = null;
            state.authenticated = false;
            state.userType = null;
        }
    }
});

export const {
    setUserID,
    setToken,
    setAuthenticated,
    setUserType,
    clearPatientAuth,
} = authSlice.actions;

export default authSlice.reducer;
