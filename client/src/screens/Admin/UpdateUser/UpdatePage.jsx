import React, {useEffect, useState} from 'react';
import axios from "../../../config/axios";
import {Link, useParams} from "react-router-dom";
import {
    Button,
    FormControl,
    FormLabel,
    IconButton,
    Input,
    Table,
    TableContainer,
    Tbody,
    Td,
    Tr
} from "@chakra-ui/react";
import {getRoleAlias, ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "../../../config/constants";
import {ArrowBackIcon} from "@chakra-ui/icons";
import { useSelector } from 'react-redux';

const UpdatePage = () => {
    const params = useParams();
    const userID = params.userId;

    const endpoint = `/api/super/users/${userID}`;
    const patientEndpoint = `/api/super/patients/${userID}`;
    const doctorEndpoint = `/api/super/doctors/${userID}`;
    const adminEndpoint = `/api/super/admins/${userID}`;

    const [personalData, setPersonalData] = useState([]);
    const [updateState, setUpdateState] = useState(false);
    const [loading, setLoading] = useState(true);

    const [updatedFirstName, setUpdatedFirstName] = useState('');
    const [updatedLastName, setUpdatedLastName] = useState('');
    const [updatedEmail, setUpdatedEmail] = useState('');
    const [updatedBirthday, setUpdatedBirthday] = useState('');
    const [updatedBirthplace, setUpdatedBirthplace] = useState('');
    const [updatedInsuranceNumber, setUpdatedInsuranceNumber] = useState('');
    const [updatedPassword, setUpdatedPassword] = useState('');

    const {
        token
    } = useSelector((state) => state.authentication)

    useEffect(() => {
        fetchUserData();
    }, []);

    const fetchUserData = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setPersonalData(response.data);
            setLoading(false);

            setUpdatedFirstName(response.data.first_name);
            setUpdatedLastName(response.data.last_name);

            if (response.data.role[0].name === ROLE_PATIENT) {
                setUpdatedBirthday(response.data.patient_detail.birthday);
                setUpdatedBirthplace(response.data.patient_detail.birthplace);
                setUpdatedInsuranceNumber(response.data.patient_detail.insurance_number);
            } else {
                setUpdatedEmail(response.data.email);
            }
        }).catch(err => {
            console.error(err);
            setLoading(false);
        });
    }

    const handleUpdate = async (role) => {
        let updateEndpoint;
        let basicDataPackage;
        let finalDataPackage;

        switch (role) {
            case ROLE_PATIENT:
                updateEndpoint = patientEndpoint;
                break;
            case ROLE_DOCTOR:
                updateEndpoint = doctorEndpoint;
                break;
            case ROLE_ADMIN:
                updateEndpoint = adminEndpoint;
                break;
            default:
                console.error('Not existing role');
                return;
        }

        if (!checkInputFields(role))
            return;

        basicDataPackage = {
            first_name: updatedFirstName,
            last_name: updatedLastName,
            password: updatedPassword,
        }

        // Create the final Update data package based on role.
        finalDataPackage = role === ROLE_PATIENT ? {
            ...basicDataPackage,
            birthday: updatedBirthday,
            birthplace: updatedBirthplace,
            insurance_number: updatedInsuranceNumber
        } :
        {
            ...basicDataPackage,
            email: updatedEmail,
        }


        await axios.put(updateEndpoint, finalDataPackage, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setUpdateState(false);
            fetchUserData();
        }).catch(err => {
            setUpdateState(false);
            console.error(err);
        });
    }

    const checkInputFields = (role) => {
        if (!updatedFirstName || !updatedLastName)
            return false;

        if (role === ROLE_PATIENT) {
            if (!updatedBirthday || !updatedBirthplace || !updatedInsuranceNumber)
                return false

            return true;
        } else {
            if (!updatedEmail)
                return false;

            return true;
        }
    }

    if (loading) {
        return (
            <div className="text-center">
                <p>Adatok betöltése...</p>
            </div>
        )
    }

    return (
        <>
            { !updateState ?
                <div>
                    <div className="my-3 mx-5">
                        <Link to={'/admin/update/users'}>
                            <IconButton
                                aria-label="Vissza"
                                colorScheme="teal"
                                icon={<ArrowBackIcon/>}
                            />
                        </Link>
                    </div>
                    <TableContainer>
                        <Table>
                            <Tbody>
                                <Tr>
                                    <Td><strong>Keresztnév:</strong> {personalData.first_name}</Td>
                                </Tr>
                                <Tr>
                                    <Td><strong>Vezetéknév: </strong>{personalData.last_name}</Td>
                                </Tr>
                                <Tr>
                                    <Td><strong>Email: </strong>{personalData.email}</Td>
                                </Tr>
                                <Tr>
                                    <Td><strong>Szerepkör: </strong>{getRoleAlias(personalData.role[0].name)}</Td>
                                </Tr>
                                {personalData.role[0].name.toLowerCase() === ROLE_PATIENT.toLowerCase() &&
                                    <>
                                        <Tr>
                                            <Td><strong>Születésnap: </strong>{personalData.patient_detail.birthday}
                                            </Td>
                                        </Tr>
                                        <Tr>
                                            <Td><strong>Születési
                                                hely: </strong>{personalData.patient_detail.birthplace}
                                            </Td>
                                        </Tr>
                                        <Tr>
                                            <Td><strong>TAJ
                                                szám: </strong>{personalData.patient_detail.insurance_number}
                                            </Td>
                                        </Tr>

                                    </>
                                }
                            </Tbody>
                        </Table>
                    </TableContainer>
                    <Button type="button" className="mt-3 mx-5" colorScheme="teal" onClick={() => setUpdateState(true)}>
                        Módosítás
                    </Button>
                </div>

                :

                <div className="mx-12 mt-5">
                    <FormControl className="mb-5">
                        <FormLabel>Vezetéknév:</FormLabel>
                        <Input
                            type="text"
                            placeholder="Vezetéknév:"
                            defaultValue={personalData.last_name}
                            onChange={(e) => setUpdatedLastName(e.target.value)}
                        />
                    </FormControl>
                    <FormControl className="mb-5">
                        <FormLabel>Keresztnév:</FormLabel>
                        <Input
                            type="text"
                            placeholder="Keresztnév:"
                            defaultValue={personalData.first_name}
                            onChange={(e) => setUpdatedFirstName(e.target.value)}
                        />
                    </FormControl>
                    <FormControl className="mb-5">
                        <FormLabel>Jelszó: (megadása nem kötelező)</FormLabel>
                        <Input
                            type='text'
                            placeholder="Jelszó:"
                            onChange={(e) => setUpdatedPassword(e.target.value)}
                        />
                    </FormControl>
                    { personalData.role[0].name !== ROLE_PATIENT &&
                        <>
                            <FormControl className="mb-5">
                                <FormLabel>Email:</FormLabel>
                                <Input
                                    type="email"
                                    placeholder="Email:"
                                    defaultValue={personalData.email}
                                    onChange={(e) => setUpdatedEmail(e.target.value)}
                                />
                            </FormControl>
                        </>
                    }
                    { personalData.role[0].name.toLowerCase() === ROLE_PATIENT &&
                        <>
                            <FormControl className="mb-5">
                                <FormLabel>Születési idő:</FormLabel>
                                <Input
                                    type="date"
                                    onChange={(e) => setUpdatedBirthday(e.target.value)}
                                    defaultValue={personalData.patient_detail.birthday}
                                />
                            </FormControl>
                            <FormControl className="mb-5">
                                <FormLabel>Születési hely:</FormLabel>
                                <Input
                                    type="text"
                                    placeholder="Születési hely:"
                                    onChange={(e) => setUpdatedBirthplace(e.target.value)}
                                    defaultValue={personalData.patient_detail.birthplace}
                                />
                            </FormControl>
                            <FormControl className="mb-5">
                                <FormLabel>TAJ szám</FormLabel>
                                <Input
                                    type="text"
                                    placeholder="TAJ szám:"
                                    onChange={(e) => setUpdatedInsuranceNumber(e.target.value)}
                                    defaultValue={personalData.patient_detail.insurance_number}
                                />
                            </FormControl>
                        </>
                    }
                    <div className="mt-5">
                        <Button
                            className="mr-5"
                            onClick={() => {
                                setUpdateState(false);
                            }}
                        >
                            Mégsem
                        </Button>
                        <Button
                            colorScheme="teal"
                            onClick={() => {
                                handleUpdate(personalData.role[0].name);
                            }}
                        >
                            Mentés
                        </Button>
                    </div>
                </div>
            }
        </>
    );
};

export default UpdatePage;