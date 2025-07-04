// import silvina from "../assets/silvi.jpg";

export default function SobreNosotros() {
    return (
        <section id='sobre' className="h-screen py-16 px-6 text-center">
            <h2 className="text-3xl font-bold mb-10">Sobre nosotros</h2>
            <div className="flex flex-col md:flex-row items-center justify-center gap-10 max-w-4xl mx-auto">
                <img
                    // src={silvina}
                    alt="Silvina Bruno"
                    className="w-64 h-64 object-cover rounded-full shadow-lg"
                />
                <div className="text-sm text-gray-700 text-left max-w-md">
                    <p>
                        Mi nombre es Silvina Bruno, corredora élite de Ultra trail running...
                    </p>
                    <p className="mt-4 font-bold text-black">
                        TE INVITO A FORMAR PARTE DE
                    </p>
                    <button className="bg-cyan-300 px-6 py-2 mt-2 text-black font-bold">
                        EN MOVIMIENTO RUN
                    </button>
                </div>
            </div>
        </section>
    );
}
