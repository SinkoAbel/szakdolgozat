import { configureStore } from '@reduxjs/toolkit';
import { persistStore, persistReducer } from 'redux-persist';
import storage from 'redux-persist/lib/storage';
import { combineReducers } from 'redux';
import registerPatientReducer from "./reducers/registerPatientSlice";
import registerDoctorReducer from "./reducers/registerDoctorSlice";
import registerAdminReducer from "./reducers/registerAdminSlice";
import authReducer from "./reducers/authSlice";

const rootReducer = combineReducers({
    registerPatient: registerPatientReducer,
    registerDoctor: registerDoctorReducer,
    registerAdmin: registerAdminReducer,
    auth: authReducer,
});

const persistConfig = {
    key: 'root',
    storage: storage,
};

const persistedReducer = persistReducer(persistConfig, rootReducer);

const store = configureStore({
    reducer: persistedReducer,
});

const persistor = persistStore(store);

export { store, persistor };