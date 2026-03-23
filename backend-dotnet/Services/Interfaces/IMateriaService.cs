using backend_dotnet.Models;
using backend_dotnet.Models.Requests;

namespace backend_dotnet.Services.Interfaces
{
    public interface IMateriaService
    {
        public Task<IEnumerable<Materia>> RetornaTodasMateriasAsync();
        public Task<Materia> RetornaMateriaPorIdAsync(int idMateria);
        public Task<Materia> RetornaMateriaPorNomeAsync(string nomeMateria);
        public Task<Materia> AtualizaMateriaAsync(AtualizarMateriaRequest materia);
        public Task<bool> CadastrarMateria(CadastrarMateriaRequest materia);
        public Task<bool> DeletarMateria(int idMateria);
    }
}
