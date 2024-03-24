import {createSlice} from "@reduxjs/toolkit";

export const registerAdminSlice = createSlice({
    name: 'registerAdmin',
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
} = registerAdminSlice.actions;

export default registerAdminSlice.reducer;
