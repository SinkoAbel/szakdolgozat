import {createSlice} from "@reduxjs/toolkit";

export const registerPatientSlice = createSlice({
    name: 'registerPatient',
    initialState: {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        birthday: '',
        birthplace: '',
        city: '',
        zip: '',
        street: '',
        house_number: '',
        insurance_number: '',
        phone: '',
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
        },
        setBirthday: (state, action) => {
            state.birthday = action.payload;
        },
        setBirthplace: (state, action) => {
            state.birthplace = action.payload;
        },
        setCity: (state, action) => {
            state.city = action.payload;
        },
        setZip: (state, action) => {
            state.zip = action.payload;
        },
        setStreet: (state, action) => {
            state.street = action.payload;
        },
        setHouseNumber: (state, action) => {
            state.house_number = action.payload;
        },
        setInsuranceNumber: (state, action) => {
            state.insurance_number = action.payload;
        },
        setPhone: (state, action) => {
            state.phone = action.payload;
        },
        resetState: (state, action) => {
            state.first_name = '';
            state.last_name = '';
            state.email = '';
            state.password = '';
            state.birthday = '';
            state.birthplace = '';
            state.city = '';
            state.zip = '';
            state.street = '';
            state.house_number = '';
            state.insurance_number = '';
            state.phone = '';
        },
    }
});

export const {
    setFirstName,
    setLastName,
    setEmail,
    setPassword,
    setBirthday,
    setBirthplace,
    setCity,
    setZip,
    setStreet,
    setHouseNumber,
    setInsuranceNumber,
    setPhone,
    resetState,
} = registerPatientSlice.actions;

export default registerPatientSlice.reducer;
