using backend_dotnet.Data;
using backend_dotnet.Models;
using Microsoft.EntityFrameworkCore;

namespace backend_dotnet.Services
{
    public class SalaAulaService 
    {
        private readonly ProfelunoContext _context;

        public SalaAulaService(ProfelunoContext context)
        {
            _context = context;
        }

        public async Task<IEnumerable<SalaAula>> RetornaTodasSalasAula()
        {
            return await _context.SalaAulas.AsNoTracking().ToListAsync();
        }

        public async Task<SalaAula> RetornaSalaAulaPorId(int idSalaAula)
        {
            return await _context.SalaAulas.FirstOrDefaultAsync(x => x.IdSalaAula == idSalaAula);
        }

        public async Task<IEnumerable<SalaAula>> RetornaSalaAulaPorProfessor(int idProfessor)
        {
            return await _context.SalaAulas.Where(x => x.IdProfessor == idProfessor).ToListAsync()
        }
    }
}