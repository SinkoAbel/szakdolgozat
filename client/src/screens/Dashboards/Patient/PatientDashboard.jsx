
const PatientDashboard = () => {

    // TODO: írjuk ki, a mai naptól kezdve a lefoglalt/elkövetkező időpontokat.
    /**
     * Mi kell ehhez? Kérjük le a felhasználóhoz tartozó lefoglalt időpontokat
     * AHOL a lefoglalt időponthoz tartozó dátum >= mai nap Y-m-d dátuma.
     */
    const endpoint = '/api/'

    return (
        <>
            <h2>Üdvözöljük a Medicare időpontfoglaló rendszerében!</h2>
            <div>
                <h3>Jelenleg nem rendelkezik időpont foglalálssal.</h3>
                <p>Amennyiben időpontot kíván foglalni kérem válasszon szakorvosaink közül.</p>
            </div>
        </>
    );
};

export default PatientDashboard;
