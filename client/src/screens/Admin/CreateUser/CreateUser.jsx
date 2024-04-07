import React, {useState} from 'react';
import {ArrowBackIcon} from "@chakra-ui/icons";

import {Button, FormControl, FormLabel, Input, Select} from "@chakra-ui/react";
import {ROLE_DOCTOR, ROLE_ADMIN} from "../../../config/constants";
import axios from "../../../config/axios";

const CreateUser = () => {
    const token = window.sessionStorage.getItem('token');

    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [password, setPassword] = useState('');
    const [role, setRole] = useState('');

    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);
    const [fieldError, setFieldError] = useState(false);
    const [requestSent, setRequestSent] = useState(false);

    const endpointAdmin = '/api/super/admins';
    const endpointDoctor = '/api/super/doctors';

    const roleObject = [
        {
            role: ROLE_DOCTOR,
            alias: 'Orvos'
        },
        {
            role: ROLE_ADMIN,
            alias: 'Admin'
        }
    ];

    const handleUserCreationRequest = async () => {
        setRequestSent(true);
        setFieldError(false);

        if (
            !firstName ||
            !lastName ||
            !password ||
            !role
        ) {
            setFieldError(true);
            setRequestSent(false);
            return;
        }

        await axios.post(role === ROLE_ADMIN ?
                                endpointAdmin :
                                endpointDoctor,
        {
            first_name: firstName,
            last_name: lastName,
            email: firstName.toLowerCase() + "." + lastName.toLowerCase() + "@medicare.com",
            password: password,
            role: role
        }, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setSuccess(true);

            setTimeout(() => {
                resetState();
            }, 3000);
        }).catch(err => {
            console.log(err);
            setError(true);

            setTimeout(() => {
                resetState();
            }, 3000);
        });
    }

    const resetState = () => {
        setSuccess(false);
        setError(false);
        setRequestSent(false);
        setFieldError(false);
        setFirstName('');
        setLastName('');
        setPassword('');
        setRole('');
    }

    return (
        <div>
            <div className="mx-12">
                <p className="mt-3 font-bold underline">
                    Felhasználó létrehozása
                </p>
                <FormControl
                    className="my-5"
                >
                    <FormLabel>Vezetéknév</FormLabel>
                    <Input
                        required
                        type={'text'}
                        placeholder="Vezetéknév:"
                        onChange={(e) => setLastName(e.target.value)}
                    />
                </FormControl>
                <FormControl
                    className="my-5"
                >
                    <FormLabel>Keresztnév</FormLabel>
                    <Input
                        required
                        type={'text'}
                        placeholder="Keresztnév:"
                        onChange={(e) => setFirstName(e.target.value)}
                    />
                </FormControl>
                <FormControl
                    className="my-5"
                >
                    <FormLabel>Jelszó</FormLabel>
                    <Input
                        required
                        type={'password'}
                        placeholder="Jelszó:"
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </FormControl>
                <FormControl
                    className="my-5"
                >
                    <FormLabel>Szerepkör</FormLabel>
                    <Select
                        required
                        onChange={(e) => setRole(e.target.value)}
                    >
                        <option value="" disabled selected>Válasszon szerepkört!</option>
                        {
                            roleObject.map((role) => {
                                return (
                                    <option key={role.role} value={role.role}>{role.alias}</option>
                                )
                            })
                        }
                    </Select>
                </FormControl>
                <FormControl
                    className="my-5"
                >
                    {fieldError &&
                        <p className="font-bold text-white text-center bg-red-600 py-3 px-3 rounded-lg mb-5">
                            Valamely input mező nem került kitöltésre!
                        </p>
                    }
                    {error &&
                        <p className="font-bold text-white text-center bg-red-600 py-3 rounded-lg mb-5">
                            Mentés sikertelen!
                        </p>
                    }
                    {success &&
                        <p className="font-bold text-white text-center bg-teal-600 py-3 rounded-lg mb-5">
                            Sikeres mentés!
                        </p>
                    }
                    {!requestSent &&
                        <Button
                            type="button"
                            colorScheme={'teal'}
                            onClick={() => handleUserCreationRequest()}
                        >
                            Mentés
                        </Button>
                    }
                </FormControl>
            </div>
        </div>
    );
};

export default CreateUser;