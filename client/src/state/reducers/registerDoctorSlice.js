import {createSlice} from "@reduxjs/toolkit";

export const registerDoctorSlice = createSlice({
    name: 'registerDoctor',
    initialState: {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
    },
    reducers: {
        setFirstName: (state, action) => {
            state.first_name = action.payload;
        },
        setLastName: (state, action) => {
            state.last_name = action.payload;
        },
        setEmail: (state, action) => {
            state.email = action.payload;
        },
        setPassword: (state, action) => {
            state.password = action.payload;
        }
    }
});

export const {
    setFirstName,
    setLastName,
    setEmail,
    setPassword
} = registerDoctorSlice.actions;

export default registerDoctorSlice.reducer;
