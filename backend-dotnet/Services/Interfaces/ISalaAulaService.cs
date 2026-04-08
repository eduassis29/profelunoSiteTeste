using backend_dotnet.Models;

namespace backend_dotnet.Services.Interfaces
{
    public interface ISalaAulaService
    {
        public Task<IEnumerable<SalaAula>> RetornaTodasSalasAula();
        public Task<SalaAula> RetornaSalaAulaPorId(int idSalaAula);
        public Task<IEnumerable<SalaAula>> RetornaSalaAulaPorProfessor(int idProfessor);
    }
}
