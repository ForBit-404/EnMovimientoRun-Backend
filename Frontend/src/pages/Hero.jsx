// import portada from "../assets/portada.jpg"; // Imagen de fondo (corredor)

export default function Hero() {
  return (
    <div
      className="relative h-screen bg-cover bg-center flex items-center justify-start text-white"
      // style={{ backgroundImage: `url(${portada})` }}
    >
      <div className="p-10 max-w-xl">
        <h1 className="text-5xl font-extrabold">RUNNING</h1>
        <hr className="w-32 border-green-400 border-t-4 my-4" />
        <p className="text-sm">
          Unete a nuestra comunidad de corredores y descubre tu potencial...
        </p>
        <div className="flex gap-6 mt-6">
          <div>
            <p className="text-green-400 text-xl font-bold">40+</p>
            <p className="text-xs">Corredores activos</p>
          </div>
          <div>
            <p className="text-green-400 text-xl font-bold">1+</p>
            <p className="text-xs">Año de experiencia</p>
          </div>
          <div>
            <p className="text-green-400 text-xl font-bold">10+</p>
            <p className="text-xs">Competencias nacionales</p>
          </div>
        </div>
      </div>
    </div>
  );
}
