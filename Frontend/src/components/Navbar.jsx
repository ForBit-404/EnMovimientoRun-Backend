export default function Navbar() {
    return (
        <nav className="flex justify-between items-center p-4 bg-black text-white">
            <div className="text-2xl font-bold">
                <span className="text-green-400">RUN</span>
            </div>
            <ul className="flex gap-6 text-sm">
                <li className="text-lime-300 font-bold">Inicio</li>
                <li>Sobre Nosotros</li>
                <li>Horarios</li>
                <li>Contacto</li>
                <li>
                    <button className="bg-lime-400 px-3 py-1 rounded text-black font-bold">
                        Iniciar sesión
                    </button>
                </li>
            </ul>
        </nav>
    );
}
