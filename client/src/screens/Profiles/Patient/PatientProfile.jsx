import React, {useEffect, useState} from 'react';
import axios from "../../../config/axios";
import {Button, FormControl, Input, Table, TableContainer, Tbody, Td, Tr} from "@chakra-ui/react";

const PatientProfile = () => {
    const userID = window.sessionStorage.getItem('user_id');
    const token = window.sessionStorage.getItem('token');
    const endpoint = '/api/patients/' + userID;

    const [userData, setUserData] = useState([]);
    const [updateState, setUpdateState] = useState(false);
    const [loading, setLoading] = useState(true);

    const [successfulUpdate, setSuccessfulUpdate] = useState(false);
    const [updateFailed, setUpdateFailed] = useState(false);

    const [updatedEmail, setUpdatedEmail] = useState('');
    const [updatedPhone, setUpdatePhone] = useState('');
    const [updatedCity, setUpdatedCity] = useState('');
    const [updatedZip, setUpdatedZip] = useState('');
    const [updatedStreet, setUpdatedStreet] = useState('');
    const [updatedHouseNumber, setUpdatedHouseNumber] = useState('');

    useEffect(() => {
        fetchUserData();
    }, []);

    const fetchUserData = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setUserData(response.data);
            console.log(response.data);
            setLoading(false);

            setUpdatedEmail(response.data.email);
            setUpdatePhone(response.data.patient_detail.phone);
            setUpdatedCity(response.data.patient_detail.city);
            setUpdatedZip(response.data.patient_detail.zip);
            setUpdatedStreet(response.data.patient_detail.street);
            setUpdatedHouseNumber(response.data.patient_detail.house_number);
        }).catch(err => {
            console.log(err);
            setLoading(false);
        });
    }

    const updateUserData = async () => {
        setSuccessfulUpdate(false);
        setUpdateFailed(false);

        if (
            !updatedEmail ||
            !updatedPhone ||
            !updatedCity ||
            !updatedZip ||
            !updatedStreet ||
            !updatedHouseNumber
        ) {
            return;
        }

        await axios.put(endpoint, {
            email: updatedEmail,
            phone: updatedPhone,
            city: updatedCity,
            zip: updatedZip,
            street: updatedStreet,
            house_number: updatedHouseNumber
        }, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            fetchUserData();
            setSuccessfulUpdate(true);
            setTimeout(() => {
                setUpdateState(false);
                setSuccessfulUpdate(false);
            }, 2000);
        }).catch(err => {
            console.log(err);

            setUpdateFailed(true);
            setTimeout(() => {
                setUpdateState(false);
            });
            setUpdateFailed(false);
        });
    }

    const handleModifyButtonClick = () => {
        setUpdateState(true);
    }

    const handleCancelModifyButtonClick = () => {
        setUpdateState(false);
    }

    const sendUpdateButtonClick = async () => {
        await updateUserData();
        await fetchUserData();
        setUpdateState(false);
    }

    if (loading) {
        return <div className="text-center">
            <p>Betöltés...</p>
        </div>
    }

    const handleInputChange = (event, field) => {
        switch (field) {
            case 'email':
                setUpdatedEmail(event.target.value);
                break;
            case 'phone':
                setUpdatePhone(event.target.value);
                break;
            case 'city':
                setUpdatedCity(event.target.value);
                break;
            case 'zip':
                setUpdatedZip(event.target.value);
                break;
            case 'street':
                setUpdatedStreet(event.target.value);
                break;
            case 'houseNumber':
                setUpdatedHouseNumber(event.target.value);
                break;
            default: return;
        }
    }

    const errorMessage = <p className="text-red-600">A mező kitöltése kötelező!</p>;

    return (
        <div>
            <p className="my-2 mx-6 font-bold underline">Felhasználói adatok:</p>

            {!updateState ?
                <>
                    <TableContainer>
                        <Table>
                            <Tbody>
                                <Tr>
                                    <Td>Email cím:</Td>
                                    <Td>{userData.email}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Telefonszám:</Td>
                                    <Td>{userData.patient_detail.phone}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Lakhely:</Td>
                                    <Td>{userData.patient_detail.city}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Irányítószám:</Td>
                                    <Td>{userData.patient_detail.zip}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Utca:</Td>
                                    <Td>{userData.patient_detail.street}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Házszám:</Td>
                                    <Td>{userData.patient_detail.house_number}</Td>
                                </Tr>
                            </Tbody>
                        </Table>
                    </TableContainer>
                    <div className="my-2 mx-2">
                        <Button
                            colorScheme={'teal'}
                            onClick={() => handleModifyButtonClick()}
                        >
                            Módosítás
                        </Button>
                    </div>
                </>
                :
                <div className="mx-6">
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.email}
                            placeholder="Email cím:"
                            type={'email'}
                            onChange={(e) => handleInputChange(e, 'email')}
                        />
                        {!updatedEmail &&
                            errorMessage}
                    </FormControl>
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.patient_detail.phone}
                            placeholder="Telefonszám:"
                            type={'tel'}
                            onChange={(e) => handleInputChange(e, 'phone')}
                        />
                        {!updatedPhone &&
                            errorMessage}
                    </FormControl>
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.patient_detail.city}
                            placeholder="Lakhely:"
                            type={'text'}
                            onChange={(e) => handleInputChange(e, 'city')}
                        />
                        {!updatedCity &&
                            errorMessage}
                    </FormControl>
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.patient_detail.zip}
                            placeholder="Irányítószám:"
                            type={'text'}
                            onChange={(e) => handleInputChange(e, 'zip')}
                        />
                        {!updatedZip &&
                            errorMessage}
                    </FormControl>
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.patient_detail.street}
                            placeholder="Utca:"
                            type={'text'}
                            onChange={(e) => handleInputChange(e, 'street')}
                        />
                        {!updatedStreet &&
                            errorMessage}
                    </FormControl>
                    <FormControl className="mb-5">
                        <Input
                            defaultValue={userData.patient_detail.house_number}
                            placeholder="Házszám:"
                            type={'number'}
                            onChange={(e) => handleInputChange(e, 'houseNumber')}
                        />
                        {!updatedHouseNumber &&
                            errorMessage}
                    </FormControl>
                    { successfulUpdate &&
                        <div className="mb-4">
                            <p className="py-2 bg-green-300 rounded-lg text-center font-bold">
                                Sikeres mentés!
                            </p>
                        </div>
                    }
                    { updateFailed &&
                        <div className="mb-4">
                            <p className="py-2 bg-red-300 rounded-lg text-center font-bold">
                                Sikertelen mentés!
                            </p>
                        </div>
                    }
                    <Button
                        className="mr-2"
                        colorScheme={'teal'}
                        onClick={() => sendUpdateButtonClick()}
                    >
                        Mentés
                    </Button>
                    <Button
                        className="ml-2"
                        colorScheme={'gray'}
                        onClick={() => handleCancelModifyButtonClick()}
                    >
                        Mégse
                    </Button>
                </div>
            }

        </div>
    );
};

export default PatientProfile;