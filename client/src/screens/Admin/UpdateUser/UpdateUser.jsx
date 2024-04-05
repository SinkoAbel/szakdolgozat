import React, {useEffect, useState} from 'react';
import {Table, TableContainer, Tbody, Th, Thead} from "@chakra-ui/react";
import axios from "../../../config/axios";

const UpdateUser = () => {
    /**
     * TODO: 1. useEffect kérjünk le minden felhasználót, az összes szerepkörből.
     *       2. Jelenítsük meg őket táblázatban.
     *       3. Ahogy az orvosok esetében úgy itt is tegyünk be módosítás és törlés menüpontot.
     *       4. Kezeljük az adatbetöltés folyamatát...mármint amég nem töltöttek be az adatok.
     *
     *
     */
    const [users, setUsers] = useState([]);

    useEffect(() => {
        fetchUsers();
    }, []);

    const fetchUsers = async () => {
        await axios.get('/api/super')
    }
    /*return (
        <p>Adatok lekérése folyamatban...</p>
    );*/

    return (
        <div className="my-4 mx-5">
            <p className="font-bold underline">
                Felhasználók kezelése:
            </p>

            <TableContainer>
                <Table>
                    <Thead>
                        <Th>Id</Th>
                        <Th>Email</Th>
                        <Th>Szerepkör</Th>
                        <Th>Módosítás</Th>
                        <Th>Törlés</Th>
                    </Thead>
                    <Tbody>

                    </Tbody>
                </Table>
            </TableContainer>
        </div>
    );
};

export default UpdateUser;