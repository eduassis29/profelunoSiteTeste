using backend_dotnet.Services.Interfaces;
using Microsoft.AspNetCore.Mvc;

namespace backend_dotnet.Controllers
{
    [ApiController]
    [Route("v1/[controller]")]
    public class SalaAulaController : ControllerBase
    {
        private readonly ISalaAulaService _salaAulaService;

        public SalaAulaController(ISalaAulaService salaAulaInterface)
        {
         _salaAulaService = salaAulaInterface;   
        }

        [HttpGet("RetornaTodasSalasAula")]
        public async Task<IActionResult> RetornaSalasAula()
        {
            var response = await _salaAulaService.RetornaTodasSalasAula();
            return Ok(response);
        }

        [HttpGet("RetornaSalaAulaPorId/{idSalaAula}")]
        public async Task<IActionResult> RetornaSalaAulaPorId(int idSalaAula)
        {
            var response = await _salaAulaService.RetornaSalaAulaPorId(idSalaAula);
            if(response == null) return NotFound();
            return Ok(response);
        }

        [HttpGet("RetornaSalaAulaPorProfessor/{idProfessor}")]
        public async Task<IActionResult> RetornaSalaAulaPorProfessor(int idProfessor)
        {
            var response = await _salaAulaService.RetornaSalaAulaPorProfessor(idProfessor);
            if(response == null) return NotFound();
            return Ok(response);
        }
    }
}