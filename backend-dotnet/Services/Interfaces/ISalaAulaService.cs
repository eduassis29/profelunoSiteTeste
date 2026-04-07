using backend_dotnet.Models;

namespace backend_dotnet.Services.Interfaces
{
    public interface ISalaAulaInterface
    {
        public Task<IEnumerable<SalaAula>> RetornaTodasSalasAula();
        public Task<SalaAula> RetornaSalaAulaPorId(int idSalaAula);
        public Task<IEnumerable<SalaAula>> RetornaSalaAulaPorProfessor(int idProfessor);
    }
}
