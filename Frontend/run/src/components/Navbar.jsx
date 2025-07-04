export default function Navbar() {
    const scrollTo = (id) => {
        const section = document.getElementById(id);
        if(section) {
            section.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
    
    return (
        <nav className="fixed top- w-full flex justify-between items-center p-4 bg-black text-white backdrop-contrast z-50"> 
            <div className="text-2xl font-bold">
                <span className="text-green-400">RUN</span>
            </div>
            <div className="flex gap-6 text-sm">
                <button onClick={() => scrollTo('inicio')} className="text-lime-300 text-lg font-bold hover:text-lime-200 transition">Inicio</button>
                <button onClick={() => scrollTo('sobre')} className="hover:text-lime-200 text-lg transition">Sobre nosotros</button>
                <button onClick={() => scrollTo('horarios')} className="hover:text-lime-200 text-lg transition">Horarios</button>
                <button onClick={() => scrollTo('contacto')} className="hover:text-lime-200 text-lg transition">Contacto</button>
                <button  className="bg-lime-400 px-3 py-1 rounded text-black text-lg font-bold">
                    Iniciar sesión
                </button>
            </div>
        </nav>
    )
}