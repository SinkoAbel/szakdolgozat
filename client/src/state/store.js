import { configureStore } from '@reduxjs/toolkit';
import { persistStore, persistReducer } from 'redux-persist';
import storage from 'redux-persist/lib/storage';
import { combineReducers } from 'redux';
import registerPatientReducer from "./reducers/registerPatientSlice";
import authenticationReducer from "./reducers/authenticationSlice";

const rootReducer = combineReducers({
    registerPatient: registerPatientReducer,
    authentication: authenticationReducer,
});

const persistConfig = {
    key: 'root',
    storage: storage,
    purge: true,
};

const persistedReducer = persistReducer(persistConfig, rootReducer);

const store = configureStore({
    reducer: persistedReducer,
});

const persistor = persistStore(store);

export { store, persistor };